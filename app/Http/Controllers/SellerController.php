<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Credential;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\UserProfile;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
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
        $shopId = Shop::where('user_id', $sellerId)->first();

        // Yesterday's date range
        // $yesterdayStart = now()->subDay()->startOfDay();
        // $yesterdayEnd = now()->subDay()->endOfDay();

        // Fetch Yesterday's Total Sales
        $pending = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->join('user_profiles', 'shops.user_id', '=', 'user_profiles.id')
            ->where('orders.order_status', 'Pending')
            ->where('shops.user_id', $sellerId) // Ensure it filters by the logged-in seller's shop
            ->distinct()  // Ensure only unique order references are counted
            ->count('orders.order_reference');  // Count unique order references


        // Fetch Total Number of Orders (for the seller)
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

        return view('main.seller.seller', [
            'pending' => $pending,
            'totalNumberOfOrders' => $totalNumberOfOrders,
            'totalIncome' => $totalIncome
        ]);
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
                        'required',
                        Rule::unique('shops')->ignore($shop->id)->where(function ($query) use ($shop) {
                            return $query->where('building_id', $shop->building_id);
                        }),
                    ],
                    'email' => 'required|email|unique:user_profiles,email,' . $userId,
                    'contact_num' => 'required|numeric|digits:11|starts_with:09|unique:user_profiles,contact_num,' . $userId,
                    'shop_image' => 'nullable|file|mimes:jpg,jpeg,png|max:51200',
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
            $product->product_name = $request->product_name;
            $product->product_description = $request->description;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->status = $request->status ? 'Available' : 'Unavailable';

            if ($product->status == 'Available') {
                $product->is_deleted = false;
            } else {
                $product->is_deleted = true;
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

                // Update product's image
                $product->image = $filename;
            }

            // Save the updated product data
            $product->save();

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

    public function delete_products($id)
    {
        try {
            $product = Product::findOrFail($id);

            $productExistinOrder = Order::where('product_id', $product->id)->first();

            if ($productExistinOrder) {
                return redirect()->back()->with('error', 'Cannot Delete Product. Existing order(s) found.');
            } else {
                // Delete the image from storage
                if ($product->image) {
                    Storage::disk('public')->delete('products/' . $product->image);
                    $product->delete();
                }
            }


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
        $orders = Order::join('products', 'orders.product_id', '=', 'products.id')
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
            ->where('orders.order_status', '!=', 'At Cart')
            ->where('orders.order_status', '!=', 'Completed')
            ->orderBy('orders.updated_at', 'desc')
            ->groupBy('orders.order_reference') // Group by the unique order_reference
            ->get();

        foreach ($orders as $order) {
            // Fetch products for each order
            $order->products = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', 'categories.id')
                ->select(
                    'products.id',
                    'products.product_name',
                    'products.price',
                    'orders.quantity',
                    'orders.total',
                    'categories.type_name'
                )
                ->where('orders.order_reference', $order->order_reference)
                ->get();
        }

        return view('main.seller.myOrders', compact('orders', 'shopDetails'));
    }

    public function updateOrder(Request $request, $orderRef)
    {
        try {
            DB::beginTransaction();

            $orderReference = Order::where('order_reference', $orderRef)->get();

            foreach ($orderReference as $order) {

                if ($order->order_status == 'Ready') {
                    $orderStatus = $request->order_status;
                } else {
                    $orderStatus = $request->order_status;
                }

                $order->order_status = $orderStatus;
                $order->save();
            }

            DB::commit();

            return redirect()->back()->with('success', 'Order status updated for all matching records.');
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
        $orders = Order::join('products', 'orders.product_id', '=', 'products.id')
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
            $order->products = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', 'categories.id')
                ->select(
                    'products.id',
                    'products.product_name',
                    'products.price',
                    'orders.quantity',
                    'orders.total',
                    'categories.type_name'
                )
                ->where('orders.order_reference', $order->order_reference)
                ->get();
        }

        return view('main.seller.orderHistory', compact('orders', 'shopDetails'));
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
