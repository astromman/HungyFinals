<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Category;
use App\Models\Credential;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Shop;
use App\Models\UserProfile;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class SellerController extends Controller
{
    public function seller_dashboard(Request $request)
    {
        $sellerId = $request->session()->get('loginId'); // Assuming seller is logged in and you get their ID
        // dd($sellerId);
        $shopId = Shop::where('user_id', $sellerId)->first()->id;

        // Yesterday's date range
        // $yesterdayStart = now()->subDay()->startOfDay();
        // $yesterdayEnd = now()->subDay()->endOfDay();

        // Fetch Pending
        $pending = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->join('user_profiles', 'shops.user_id', '=', 'user_profiles.id')
            ->where('orders.order_status', 'Pending')
            ->where('shops.user_id', $sellerId) // Ensure it filters by the logged-in seller's shop
            ->distinct()  // Ensure only unique order references are counted
            ->count('orders.order_reference');  // Count unique order references

        // Fetch Total Number of Completed Orders (for the seller)
        $totalNumberOfOrders = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->where('orders.order_status', 'Completed')
            ->where('shops.user_id', $sellerId) // Ensure it matches the logged-in seller
            ->distinct()  // Ensure only unique order references are counted
            ->count('orders.order_reference');  // Count unique order references

        // Fetch Total Income (All Time Sales)
        $totalIncome = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->where('shops.user_id', $sellerId) // Ensure it matches the logged-in seller
            ->where('orders.order_status', 'Completed')
            ->sum('orders.total');

        // PIE CHART
        // Query to get the sum of sold items for each category in the seller's shop
        $categoriesData = DB::table('categories')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->join('orders', 'orders.product_id', 'products.id')
            ->select('categories.type_name', DB::raw('SUM(products.sold) as total_sold'))
            ->where('categories.shop_id', $shopId)
            ->where('orders.order_status', 'Completed')
            ->groupBy('categories.type_name')
            ->pluck('total_sold', 'categories.type_name')
            ->toArray();

        // Fetch Total Sold Items
        $totalSoldItems = array_sum(array_values($categoriesData));

        // BAR GRAPH (Modified to count unique order_reference)
        $dailyOrders = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->select(DB::raw('DATE(orders.created_at) as order_date'), DB::raw('COUNT(DISTINCT orders.order_reference) as total_orders'))
            ->where('products.shop_id', $shopId)
            ->where('orders.order_status', '!=', 'At Cart')
            ->groupBy('order_date')
            ->orderBy('order_date', 'ASC')
            ->pluck('total_orders', 'order_date')
            ->toArray();

        // Fetch total sales for the current seller's shop per day
        $salesPerShop = DB::table('orders')
            ->join('products', 'orders.product_id', 'products.id')
            ->join('shops', 'products.shop_id', 'shops.id')
            ->where('shops.user_id', $sellerId)
            ->where('orders.order_status', 'Completed')
            ->select(DB::raw('SUM(orders.total) as total_sales'), DB::raw('DATE(orders.created_at) as sale_date'))
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->get();

        return view('main.seller.seller', compact(
            'pending',
            'totalNumberOfOrders',
            'totalIncome',
            'categoriesData',
            'dailyOrders',
            'totalSoldItems',
            'salesPerShop',
        ));
    }

    // PASSWORD
    public function seller_change_password()
    {
        return view('main.seller.password');
    }

    public function update_password(Request $request)
    {
        $userId = $request->session()->get('loginId');
        $credential = Credential::where('user_id', $userId)
            ->where('is_deleted', false)
            ->first();

        if (empty($request->current_password)) {
            return redirect()->back()->with('error', 'Enter Current Password.');
        }

        if (!Hash::check($request->input('current_password'), $credential->password)) {
            return redirect()->back()->with('error', 'The provided current password does not match our records.');
        }

        try {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[A-Z])(?=.*[\W_]).+$/'
                ],
                'confirm_password' => 'required|same:new_password',
            ], [
                'current_password.required' => 'Current password is required.',
                'new_password.required' => 'New password is required.',
                'new_password.min' => 'New password must be at least 8 characters.',
                'new_password.regex' => 'New password must include at least one uppercase letter and one special character.',
                'confirm_password.required' => 'New password confirmation is required.',
                'confirm_password.same' => 'New password and confirmation do not match.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            DB::beginTransaction();

            // Mark the old password as deleted
            $credential->is_deleted = true;
            $credential->save();

            // Store the new password
            $newCredential = new Credential();
            $newCredential->user_id = $userId;
            $newCredential->password = Hash::make($request->input('new_password'));
            $newCredential->is_deleted = false;
            $newCredential->created_at = now();
            $newCredential->updated_at = now();
            $newCredential->save();

            DB::commit();
            return redirect()->route('seller.change.password')->with('success', 'Password changed successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    // SHOP
    public function shop_view_mode(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $userProfile = UserProfile::where('id', $userId)->first();

        $shopDetails = Shop::join('user_profiles', 'shops.user_id', 'user_profiles.id')
            ->select(
                'shops.*',
                'shops.shop_name',
                'user_profiles.contact_num',
            )
            ->where('user_id', $userId)
            ->first();

        // Get the products owned by the shop, along with their categories
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.*',
                'categories.type_name as category_name',
            )
            ->where('products.shop_id', $shopDetails->id)
            ->where('products.status', 'Available')
            ->get();

        // Group products by category
        $groupedProducts = $products->groupBy('category_name');

        return view('main.seller.viewShop', compact('userProfile', 'shopDetails', 'products', 'groupedProducts'));
    }

    public function shop_update_details(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $userProfile = UserProfile::where('id', $userId)->first();

        $shopDetails = Shop::where('user_id', $userId)->first();

        return view('main.seller.shopDetails', compact('userProfile', 'shopDetails'));
    }

    public function update_shop_status(Request $request)
    {
        try {
            // Get the currently authenticated user's shop
            $userId = $request->session()->get('loginId');
            $shop = Shop::where('user_id', $userId)->first();

            // Update the is_reopen column based on the switch
            $shop->is_reopen = $request->is_reopen;
            $shop->updated_at = now();
            $shop->save();

            // Redirect back with success message
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            // Handle exceptions
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function update_details(Request $request)
    {
        $userId = $request->session()->get('loginId');
        $shop = Shop::where('user_id', $userId)->first();

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'username' => 'required|unique:user_profiles,username,' . $userId,
                    'shop_name' => [
                        'nullable',
                        Rule::unique('shops')->ignore($shop->id)->where(function ($query) use ($shop) {
                            return $query->where('building_id', $shop->building_id);
                        }),
                    ],
                    'email' => 'required|email|unique:user_profiles,email,' . $userId,
                    'contact_num' => 'required|numeric|digits:11|starts_with:09|unique:user_profiles,contact_num,' . $userId,
                    'shop_image' => 'nullable|file|mimes:jpg,jpeg,png|max:51200',
                    'shop_qr' => 'nullable|file|mimes:jpg,jpeg,png|max:51200',
                    'shop_bio' => 'nullable|max:255',
                ],
                [
                    'username.required' => 'Username is required',
                    'username.unique' => 'Username already exists',
                    'shop_name.required' => 'Shop name is required',
                    'shop_name.unique' => 'Shop name already exists',
                    'email.required' => 'Email is required',
                    'email.email' => 'Invalid email',
                    'email.unique' => 'Email already exists',
                    'contact_num.required' => 'Contact number is required',
                    'contact_num.numeric' => 'Invalid contact number',
                    'contact_num.digits' => 'Invalid contact number',
                    'contact_num.starts_with' => 'Invalid contact number',
                    'contact_num.unique' => 'Contact number already exists',
                    'shop_image.required' => 'Shop image is required',
                    'shop_image.image' => 'Invalid image',
                    'shop_image.mimes' => 'Invalid image type',
                    'shop_image.max' => 'Image size should not exceed 50MB',
                    'shop_bio.max' => 'Shop bio should not exceed 255 characters',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $userProfile = UserProfile::findOrFail($userId);
            $userProfile->username = $request->username;
            $userProfile->email = $request->email;
            $userProfile->contact_num = $request->contact_num;
            $userProfile->updated_at = now();
            $userProfile->save();

            $shop = Shop::where('user_id', $userId)->first();

            if ($request->hasFile('shop_image')) {
                // Delete old image if exists
                if ($shop->shop_image) {
                    Storage::disk('public')->delete('shop/' . $shop->shop_image);
                }

                // Store new image
                $image = time() . '_' . $request->shop_name . '_' . $request->shop_image->getClientOriginalName();
                $request->file('shop_image')->storeAs('shop', $image, 'public');
                $shop->shop_image = $image;
            }

            if ($request->hasFile('qr_image')) {
                // Delete old image if exists
                if ($shop->shop_qr) {
                    Storage::disk('public')->delete('shop/' . $shop->shop_qr);
                }

                // Store new image
                $image = time() . '_' . $request->shop_name . '_' . $request->qr_image->getClientOriginalName();
                $request->file('qr_image')->storeAs('shop', $image, 'public');
                $shop->shop_qr = $image;
            }

            $shop->shop_name = $request->shop_name;
            $shop->shop_bio = $request->shop_bio;
            $shop->updated_at = now();
            $shop->save();

            DB::commit();
            return redirect()->route('shop.update.details')->with('success', 'Shop updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (FileException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'File upload error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    // PRODUCTS
    public function my_products(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $shopDetails = Shop::join('user_profiles', 'shops.user_id', 'user_profiles.id')
            ->select(
                'shops.*',
                'shops.shop_name',
                'user_profiles.contact_num',
            )
            ->where('user_id', $userId)
            ->first();

        // Get the products owned by the shop, along with their categories
        $category_id = $request->category_id;
        $query = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.*',
                'categories.type_name as category_name'
            )
            ->where('products.shop_id', $shopDetails->id);

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        $products = $query->get();

        $hasProducts = Product::where('shop_id', $shopDetails->id)->value('id');

        $categories = Category::where('shop_id', $shopDetails->id)->get();

        return view('main.seller.addProduct', compact('products', 'shopDetails', 'categories', 'category_id', 'hasProducts'));
    }

    public function add_products(Request $request)
    {
        $userId = $request->session()->get('loginId');
        $shop = Shop::where('user_id', $userId)->first();

        try {
            $validator = Validator::make(request()->all(), [
                'product_name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:5000',
                'description' => 'nullable|string|max:1000',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $products = new Product();

            if ($request->hasFile('image')) {
                $image = time() . '_' . $shop->shop_name . '_' . $request->image->getClientOriginalName();
                $request->file('image')->storeAs('products', $image, 'public');
                $products->image = $image;
            }

            $description = "";

            $products->product_name = $request->product_name;
            $products->product_description = $request->description;
            $products->price = $request->price;
            $products->sold = 0;
            $products->category_id = $request->category_id;
            $products->status = 'Available';
            $products->shop_id = $shop->id;
            $products->created_at = now();
            $products->updated_at = now();
            $products->is_deleted = false;
            $products->save();

            DB::commit();

            $description .= "a product named " . $products->product_name . ", with a price of " . $products->price . ". And description " . $products->product_description;
            $commonUtility = new CommonUtilityController();
            $commonUtility->addAuditTrail($userId, 1, $shop->shop_name . ' Added ' . $description);

            return redirect()->route('my.products')->with('success', 'Product Added successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (FileException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'File upload error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function edit_products(Request $request)
    {
        $userId = $request->session()->get('loginId');
        $shop = Shop::where('user_id', $userId)->first();

        // Validate the form inputs
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5000',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|string',
        ]);

        // Redirect back if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Find the product to be updated
            $product = Product::where('id', $request->id)->where('shop_id', $shop->id)->first();

            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            // Update product details
            $description = "";
            if ($product->product_name != $request->product_name) {
                $description .= "Product Name changed from " . $product->product_name . " to " . $request->product_name;
                $product->product_name = $request->product_name;
            }

            if ($product->product_description != $request->description) {
                $description .= "Description for " . $product->product_name . " changed from " . $product->product_description . " to " . $request->description;
                $product->product_description = $request->description;
            }

            if ($product->price != $request->price) {
                $description .= "Price for " . $product->product_name . " changed from " . $product->price . " to " . $request->price;
                $product->price = $request->price;
            }

            if ($product->category_id != $request->category_id) {

                $oldCategory = Category::where('id', $product->category_id)->first()->type_name;
                $newCategory = Category::where('id', $request->category_id)->first()->type_name;

                $description .= "Category for " . $product->product_name . " changed from " . $oldCategory . " to " . $newCategory;
                $product->category_id = $request->category_id;
            }

            // Toggle status between 'Available' and 'Unavailable' based on the form submission
            $unavailable = $request->status == 'Available' ? 'Available' : 'Unavailable';

            if ($product->status != $unavailable) {
                if ($unavailable == 'Available') {
                    $oldProductStatus = 'Unavailable';
                    $newProductStatus = 'Available';
                    $description .= "Product Status for " . $product->product_name . " changed from " . $oldProductStatus . " to " . $newProductStatus;
                    $product->is_deleted = false; // Product is not deleted when it's available
                } else {
                    $oldProductStatus = 'Available';
                    $newProductStatus = 'Unavailable';
                    $description .= "Product Status for " . $product->product_name . " changed from " . $oldProductStatus . " to " . $newProductStatus;
                    $product->is_deleted = true; // Product is marked as deleted when unavailable
                }

                // Update the product's status
                $product->status = $unavailable;
                $product->save();
            }

            // Handle the image upload if a new image is provided
            if ($request->hasFile('image')) {
                // Delete the old image from storage
                if ($product->image) {
                    Storage::delete('public/products/' . $product->image);
                }

                // Store the new image
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/products', $filename);

                $description .= "Product Image for " . $product->product_name;
                // Update product's image
                $product->image = $filename;
            }

            // Save the updated product data
            $product->save();

            $commonUtility = new CommonUtilityController();
            $commonUtility->addAuditTrail($userId, 2, $shop->shop_name . ' Updated ' . $description);

            return redirect()->route('my.products')->with('success', 'Product updated successfully.');
        } catch (QueryException $e) {
            // Rollback in case of a database error
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (FileException $e) {
            // Rollback in case of a file upload error
            return redirect()->back()->with('error', 'File upload error: ' . $e->getMessage());
        } catch (Exception $e) {
            // Catch any other exception
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    // public function addAuditTrail($userId, $actionType, $description)
    // {
    //     if ($actionType == 1) {
    //         $action = "ADD";
    //     } elseif ($actionType == 2) {
    //         $action = "\UPDATE";
    //     } elseif ($actionType == 3) {
    //         $action = "\DELETE";
    //     }

    //     $audit = new Audit;
    //     $audit->user_id = $userId;
    //     $audit->action = $action;
    //     $audit->description = $description;
    //     $audit->created_at = now();
    //     $audit->updated_at = now();
    //     $audit->save();

    // }

    public function delete_products(Request $request, $id)
    {
        $userId = $request->session()->get('loginId');
        $shop = Shop::where('user_id', $userId)->first();
        $description = "";

        try {
            $product = Product::findOrFail($id);

            $productExistinOrder = Order::where('product_id', $product->id)->first();

            if ($productExistinOrder) {
                return redirect()->back()->with('error', 'Cannot Delete Product. Existing order(s) found.');
            } else {
                // Delete the image from storage
                if ($product->image) {
                    Storage::disk('public')->delete('products/' . $product->image);
                    $description .= "a product named " . $product->product_name;
                    $product->delete();
                }
            }

            $commonUtility = new CommonUtilityController();
            $commonUtility->addAuditTrail($userId, 3, $shop->shop_name . ' Deleted ' . $description);

            return redirect()->route('my.products.table')->with('success', 'Product deleted successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            $errorInfo = $e->errorInfo[1];

            if ($errorInfo == 1451) {
                return redirect()->back()->with('error', 'Cannot Delete Product. Existing order(s) found.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred.');
        }
    }

    public function my_products_table(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $shopDetails = Shop::join('user_profiles', 'shops.user_id', 'user_profiles.id')
            ->select(
                'shops.*',
                'shops.shop_name',
                'user_profiles.contact_num',
            )
            ->where('user_id', $userId)
            ->first();

        // Get the products owned by the shop, along with their categories
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.*',
                'categories.type_name as category_name'
            )
            ->where('products.shop_id', $shopDetails->id)
            ->get();

        $hasProducts = Product::where('shop_id', $shopDetails->id)->value('id');

        $categories = Category::where('shop_id', $shopDetails->id)->get();

        return view('main.seller.myProducts', compact('products', 'shopDetails', 'categories', 'hasProducts'));
    }

    // CATEGORIES
    public function product_categories(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $shopDetails = Shop::where('user_id', $userId)->first();

        $categories = Category::where('shop_id', $shopDetails->id)->get();

        return view('main.seller.addCategory', compact('categories', 'shopDetails'));
    }

    public function add_category(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $shop = Shop::where('user_id', $userId)->first();

        try {
            $validator = Validator::make($request->all(), [
                'type_name' => [
                    'required',
                    Rule::unique('categories')->where(function ($query) use ($shop) {
                        return $query->where('shop_id', $shop->id);
                    }),
                ],
            ], [
                'type_name.required' => 'Category name is required',
                'type_name.unique' => 'Category name already exists for your shop',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $category = new Category();
            $category->type_name = $request->type_name;
            $category->shop_id = $shop->id;
            $category->created_at = now();
            $category->updated_at = now();
            $category->save();

            DB::commit();
            return redirect()->back()->with('success', 'Category added successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function edit_button_category(Request $request, $id)
    {
        $userId = $request->session()->get('loginId');

        $shopDetails = Shop::where('user_id', $userId)->first();

        $categories = Category::where('shop_id', $shopDetails->id)->get();

        $categoryId = Category::findOrFail($id);
        return view('main.seller.addCategory', compact('categories', 'categoryId', 'shopDetails'));
    }

    public function edit_category(Request $request, $id)
    {
        try {
            $validator = Validator::make(request()->all(), [
                'type_name' => 'required|unique:categories,type_name',
            ], [
                'type_name.required' => 'Category name is required',
                'type_name.unique' => 'Category name already exists',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $category = Category::findOrFail($id);
            $category->type_name = $request->type_name;
            $category->save();

            return redirect()->route('product.categories')->with('success', 'Category updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function delete_category($id)
    {
        try {
            $categories = Category::findOrFail($id);
            $categories->delete();
            return redirect()->back()->with('success', 'Category deleted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            $errorInfo = $e->errorInfo[1];

            if ($errorInfo == 1451) {
                return redirect()->back()->with('error', 'Cannot delete category. Existing products found.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    // ORDERS
    public function my_orders(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $shopDetails = Shop::where('user_id', $userId)->first();

        // Fetch the shop ID for the logged-in seller
        $shopId = Shop::where('user_id', $userId)->first()->id;

        // Get all unique orders for this seller's shop
        $orders = Order::join('product_orders', 'orders.product_orders_id', 'product_orders.id')
            ->join('products', 'orders.product_id', 'products.id')
            ->join('user_profiles', 'orders.user_id', 'user_profiles.id')
            ->join('payments', 'orders.payment_id', 'payments.id')
            ->select(
                'orders.id',
                'orders.order_reference',
                'orders.created_at',
                'orders.updated_at',
                'orders.total',
                'orders.quantity',
                'orders.order_status',
                'user_profiles.first_name',
                'user_profiles.last_name',
                'user_profiles.email_verified_at',
                'payments.payment_id',
                'payments.payment_status',
                'payments.payment_type',
            )
            ->where('products.shop_id', $shopId) // Make sure shopId is correct here
            ->whereNotNull('user_profiles.email_verified_at')
            ->where('orders.at_cart', false)
            ->where('orders.order_status', '!=', 'At Cart')
            ->where('orders.order_status', '!=', 'Completed')
            ->orderBy('orders.created_at', 'desc')
            ->groupBy('orders.order_reference') // Group by the unique order_reference
            ->get();

        foreach ($orders as $order) {
            // Fetch products for each order
            $order->products = Order::join('product_orders', 'orders.product_orders_id', '=', 'product_orders.id')
                ->join('products', 'orders.product_id', 'products.id')
                // ->join('categories', 'products.category_id', 'categories.id')
                ->select(
                    'product_orders.product_name',
                    'product_orders.category_name',
                    'product_orders.price',
                    'orders.quantity',
                    'orders.total',
                )
                ->where('orders.order_reference', $order->order_reference)
                ->get();
        }

        return view('main.seller.myOrders', compact('orders', 'shopDetails'));
    }

    public function getAveragePreparationTime($shopId)
    {
        // Get the average preparation time for the shop in minutes
        $averagePreparationTime = Order::join('products', 'orders.product_id', '=', 'products.id')
            ->select(
                DB::raw('AVG(TIMESTAMPDIFF(MINUTE, orders.created_at, orders.updated_at)) as avg_preparation_time')
            )
            ->where('products.shop_id', $shopId)
            ->where('orders.order_status', 'Completed') // Only consider completed orders
            ->orWhere('orders.order_status', 'Ready')
            ->value('avg_preparation_time');

        return $averagePreparationTime;
    }

    public function updateOrder(Request $request, $orderRef)
    {
        try {
            DB::beginTransaction();

            $orderReference = Order::where('order_reference', $orderRef)->get();

            foreach ($orderReference as $order) {
                $orderStatus = $request->order_status;
                // dd($orderStatus);

                $order->order_status = $orderStatus;
                $order->updated_at = now();
                $order->save();

                $productId = Order::where('order_reference', $orderRef)->first()->product_id;
                $shopId = Product::where('id', $productId)->first()->shop_id;
            }

            // After the order is updated, calculate the new average preparation time
            if ($shopId && $order->order_status == 'Ready') {
                $averagePreparationTime = $this->getAveragePreparationTime($shopId);

                // Update the shop with the new average preparation time
                Shop::where('id', $shopId)->update(['preparation_time' => $averagePreparationTime]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Order status updated.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong while updating the order.');
        }
    }

    public function order_history(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $shopDetails = Shop::where('user_id', $userId)->first();

        // Fetch the shop ID for the logged-in seller
        $shopId = Shop::where('user_id', $userId)->first()->id;

        // Get all unique orders for this seller's shop
        $orders = Order::join('product_orders', 'orders.product_orders_id', 'product_orders.id')
            ->join('products', 'orders.product_id', 'products.id')
            ->join('user_profiles', 'orders.user_id', '=', 'user_profiles.id')
            ->join('payments', 'orders.payment_id', 'payments.id')
            ->select(
                'orders.id',
                'orders.order_reference',
                'orders.created_at',
                'orders.updated_at',
                'orders.total',
                'orders.quantity',
                'orders.order_status',
                'user_profiles.first_name',
                'user_profiles.last_name',
                'user_profiles.contact_num',
                'payments.payment_id',
                'payments.payment_status',
                'payments.payment_type',
            )
            // Filter orders by the shop_id
            ->where('products.shop_id', $shopId)
            ->where('orders.at_cart', false)
            ->where('orders.order_status', 'Completed')
            ->orderBy('orders.updated_at', 'desc')
            ->groupBy('orders.order_reference') // Group by the unique order_reference
            ->get();

        foreach ($orders as $order) {
            // Fetch products for each order
            $order->products = Order::join('product_orders', 'orders.product_orders_id', '=', 'product_orders.id')
                // ->join('categories', 'products.category_id', 'categories.id')
                ->select(
                    'product_orders.id',
                    'product_orders.product_name',
                    'product_orders.price',
                    'orders.quantity',
                    'orders.total',
                    // 'categories.type_name'
                )
                ->where('orders.order_reference', $order->order_reference)
                ->get();
        }

        return view('main.seller.orderHistory', compact('orders', 'shopDetails'));
    }

    public function confirmPayment(Request $request)
    {
        $orderId = $request->input('order_id');

        // Find the order and its payment
        $order = Order::findOrFail($orderId);
        $payment = Payment::findOrFail($order->payment_id);

        // Update the payment status to "Completed"
        $payment->payment_status = 'Completed';
        $payment->save();

        return redirect()->back()->with('success', 'Payment confirmed successfully.');
    }

    public function rejectPayment(Request $request)
    {
        // Validate the input fields to ensure that order_reference and feedback are provided
        $request->validate([
            'order_reference' => 'required|exists:orders,order_reference', // Validate that order_reference exists in the orders table
            'feedback' => 'required|string|max:255',  // Validate feedback as required and of proper length
        ]);

        try {
            DB::beginTransaction();  // Begin transaction to ensure atomicity

            $orderReference = $request->order_reference;
            $feedback = $request->input('feedback');

            // Find all orders with the given order_reference
            $orders = Order::where('order_reference', $orderReference)->get();

            // Ensure that orders are retrieved successfully, otherwise throw an error
            if ($orders->isEmpty()) {
                throw new Exception("No orders found with the reference " . $orderReference);
            }

            foreach ($orders as $order) {
                // Find the associated payment
                $payment = Payment::findOrFail($order->payment_id);

                // Update payment status to 'Rejected' and add the feedback
                $payment->feedback = $feedback;
                $payment->payment_status = 'Rejected';
                $payment->updated_at = now();
                $payment->save();

                // Update the order status back to 'At Cart' and clear the order reference
                $order->order_status = 'At Cart';
                $order->order_reference = null;
                $order->at_cart = true; // Mark as in cart
                $order->updated_at = now();
                $order->save();
            }

            DB::commit();  // Commit the transaction

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Payment rejected successfully for the order reference: ' . $orderReference . '. Feedback: ' . $feedback);
        } catch (Exception $e) {
            DB::rollBack();  // Roll back the transaction in case of an error
            return redirect()->back()->with('error', 'Failed to reject payment: ' . $e->getMessage());
        }
    }


    // VERIFICATION
    public function verified(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $shopDetails = Shop::join('user_profiles', 'shops.user_id', 'user_profiles.id')
            ->select(
                'shops.*',
                'shops.shop_name',
                'user_profiles.contact_num',
            )
            ->where('user_id', $userId)
            ->first();

        return view('main.seller.verified', compact('shopDetails'));
    }
}
