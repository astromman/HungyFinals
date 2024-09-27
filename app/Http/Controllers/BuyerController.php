<?php

namespace App\Http\Controllers;

use App\Events\NewOrderPlaced;
use App\Models\Building;
use App\Models\Category;
use App\Models\Credential;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Review;
use App\Models\Shop;
use App\Models\UserProfile;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class BuyerController extends Controller
{
    //
    public function landing_page(Request $request)
    {
        $canteens = Building::all();
        $products = Product::all();

        $userId = $request->session()->get('loginId');

        if (!$userId) {
            return redirect()->route('user.logout')->with('error', 'Invalid request!');
        }

        // Fetch all orders in cart, using LEFT JOIN to handle orders without payment info
        $orders = Order::leftJoin('products', 'orders.product_id', 'products.id')
            ->leftJoin('payments', 'orders.payment_id', 'payments.id')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->leftJoin('shops', 'products.shop_id', 'shops.id')
            ->leftJoin('buildings', 'shops.building_id', 'buildings.id')
            ->select(
                'orders.*',
                'products.product_name',
                'products.product_description',
                'products.image',
                'products.price',
                'products.category_id',
                'products.shop_id',
                'products.status',
                'products.is_deleted',
                'categories.type_name',
                'shops.shop_name',
                'buildings.building_name as designated_canteen',
                'payments.payment_status', // Include payment details if exists
                'payments.feedback',
            )
            ->where('products.status', 'Available')
            ->where('products.is_deleted', false)
            ->where('orders.user_id', $userId)
            // ->where('orders.at_cart', true) // Only get orders still in the cart
            // ->where('orders.order_status', 'At Cart') // Orders that are in cart state
            ->orderBy('orders.updated_at', 'desc')
            ->get();

        return view('main.buyer.landingpage', compact('canteens', 'products', 'orders'));
    }

    public function about_us_page()
    {
        return view('main.buyer.about');
    }

    public function my_favorites(Request $request)
    {
        $userId = $request->session()->get('loginId'); // Retrieve the user ID from the session

        if (!$userId) {
            return redirect()->route('user.logout')->with('error', 'Invalid request!');
        }

        // Retrieve the favorite products for the logged-in user
        $favorites = Product::join('favorites', 'products.id', '=', 'favorites.product_id')
            ->where('favorites.user_id', $userId)
            ->select('products.*')
            ->get();

        $reviews = Review::all();

        return view('main.buyer.favorites', compact('favorites', 'reviews'));
    }

    //ADD TO FAVORITES 
    public function addToFavorites(Request $request)
    {
        $userId = $request->session()->get('loginId');

        if (!$userId) {
            return redirect()->route('user.logout')->with('error', 'Invalid request!');
        }

        try {
            DB::beginTransaction();

            // Check if the item is already in the favorites list
            $existingFavorite = Favorite::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->first();

            if ($existingFavorite) {
                // If the item is already in the favorites, return with a message
                return redirect()->back()->with('info', 'This item is already in your favorites!');
            } else {
                // Add the item to the favorites
                $favorite = new Favorite;
                $favorite->user_id = $userId;
                $favorite->product_id = $request->product_id;
                $favorite->created_at = now();
                $favorite->updated_at = now();
                $favorite->save();
            }

            DB::commit();

            return redirect()->back()->with('successFavorites', 'Item added to favorites!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add product to favorites!');
        }
    }

    //REMOVE FROM FAVORITES PAGE
    public function removeFavorite(Request $request, $productId)
    {
        $userId = $request->session()->get('loginId');
        // \Log::info('User ID: ' . $userId);
        // \Log::info('Product ID: ' . $productId);

        try {
            DB::beginTransaction();

            $favorite = Favorite::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($favorite) {
                $favorite->delete();
                DB::commit();
                return response()->json(['success' => true]);
            } else {
                // \Log::info('Item not found for user ID: ' . $userId . ' and product ID: ' . $productId);
                return response()->json(['success' => false, 'message' => 'Item not found in favorites.'])->header('Content-Type', 'text/plain');
            }
        } catch (Exception $e) {
            DB::rollBack();
            // \Log::error('Error while removing favorite: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to remove product from favorites.'])->header('Content-Type', 'text/plain');
        }
    }

    //SEARCH FUNCTION (❁´◡`❁)
    public function searchItem(Request $request)
    {
        $searchTerm = $request->input('query');

        if ($searchTerm == "") {
            return redirect()->back();
        }

        // Search for shops
        $shops = Shop::join('user_profiles', 'shops.user_id', 'user_profiles.id')
            ->join('buildings', 'shops.building_id', 'buildings.id')
            ->select(
                'shops.*',
                'shops.shop_name',
                'user_profiles.contact_num',
                'buildings.building_name as designated_canteen'
            )
            ->where('shop_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('buildings.building_name', 'LIKE', '%' . $searchTerm . '%')
            ->get();

        // Search for products
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.*',
                'categories.type_name as category_name'
            )
            ->where('products.product_name', 'LIKE', '%' . $searchTerm . '%')  // Corrected column name
            ->orWhere('categories.type_name', 'LIKE', '%' . $searchTerm . '%')
            ->get();

        $reviews = Review::all();

        // Group products by category
        $groupedProducts = $products->groupBy('category_name');

        return view('main.buyer.search-results', compact('shops', 'groupedProducts', 'searchTerm', 'reviews'));
    }

    public function my_profile(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $userProfile = UserProfile::where('id', $userId)->first();

        return view('main.buyer.profile', compact('userProfile'));
    }

    public function update_profile(Request $request)
    {
        $userId = $request->session()->get('loginId');

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'username' => 'required|unique:user_profiles,username,' . $userId,
                    'email' => 'required|email|unique:user_profiles,email,' . $userId,
                ],
                [
                    'first_name.required' => 'First name is required.',
                    'last_name.required' => 'Last name is required.',
                    'username.required' => 'Username is required.',
                    'username.unique' => 'Username is already taken.',
                    'email.required' => 'Email is required.',
                    'email.email' => 'Invalid email.',
                    'email.unique' => 'Email already exists.',
                ]
            );

            // This block will check if the inputted infos are valid
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $userProfile = UserProfile::where('id', $userId)->first();
            $userProfile->first_name = $request->first_name;
            $userProfile->last_name = $request->last_name;
            $userProfile->email = $request->email;
            $userProfile->username = $request->username;
            $userProfile->updated_at = now();
            $userProfile->save();

            DB::commit();
            return redirect()->route('landing.page')->with('success', 'Profile updated');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function buyer_change_password()
    {
        return view('main.buyer.password');
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
            return redirect()->route('buyer.change.password')->with('success', 'Password changed successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    // VISIT A SPECIFIC CANTEEN THAT IS FEATURED IN THE LANDING PAGE
    public function visit_canteen(Request $request, $id, $building_name)
    {
        // Find the canteen by both the ID and slugified name
        $canteen = Building::where('id', $id)
            ->where(DB::raw('LOWER(REPLACE(building_name, " ", "-"))'), strtolower($building_name))
            ->firstOrFail();

        $shops = Shop::where('building_id', $canteen->id)
            ->where('status', 'Verified')
            ->get();

        return view('main.buyer.canteenDetail', compact('canteen', 'shops'));
    }

    // LISTS OF SHOP FROM THE NAVBAR
    public function shops_list(Request $request)
    {
        $building_id = $request->building_id;
        $query = Shop::join('buildings', 'shops.building_id', 'buildings.id')
            ->select(
                'shops.*',
                'buildings.id as building_id',
                'buildings.building_name as designated_canteen',
            )
            ->where('status', 'Verified');

        if ($building_id) {
            $query->where('building_id', $building_id);
        }

        $shops = $query->orderBy('created_at', 'desc')->get();

        $buildings = Building::all();
        return view('main.buyer.shops', compact('shops', 'buildings', 'building_id'));
    }

    // VISIT A SPECIFIC SHOP 
    public function visit_shop(Request $request, $id, $shop_name)
    {
        // URL generation
        $shops = Shop::join('user_profiles', 'shops.user_id', 'user_profiles.id')
            ->join('buildings', 'shops.building_id', 'buildings.id')
            ->select(
                'shops.*',
                'shops.shop_name',
                'user_profiles.contact_num',
                'buildings.building_name as designated_canteen',
            )
            ->where('shops.id', $id)
            ->where(DB::raw('LOWER(REPLACE(REPLACE(shop_name, "\'", ""), " ", "-"))'), strtolower($shop_name))
            ->firstOrFail();

        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.*',
                'categories.type_name as category_name'
            )
            ->where('products.shop_id', $id)
            // ->where('products.status', 'Available')
            ->get();

        $reviews = Review::all();

        // Group products by category
        $groupedProducts = $products->groupBy('category_name');

        return view('main.buyer.shop-menu', compact('shops', 'products', 'groupedProducts', 'reviews'));
    }

    // CART
    public function shop_cart(Request $request)
    {
        $userId = $request->session()->get('loginId');

        // Fetch all orders in cart, using LEFT JOIN to handle orders without payment info
        $orders = Order::leftJoin('products', 'orders.product_id', 'products.id')
            ->leftJoin('payments', 'orders.payment_id', 'payments.id')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->leftJoin('shops', 'products.shop_id', 'shops.id')
            ->leftJoin('buildings', 'shops.building_id', 'buildings.id')
            ->select(
                'orders.*',
                'products.product_name',
                'products.product_description',
                'products.image',
                'products.price',
                'products.category_id',
                'products.shop_id',
                'products.status',
                'products.is_deleted',
                'categories.type_name',
                'shops.shop_name',
                'buildings.building_name as designated_canteen',
                'payments.payment_status', // Include payment details if exists
                'payments.feedback',
            )
            ->where('products.status', 'Available')
            ->where('products.is_deleted', false)
            ->where('orders.user_id', $userId)
            ->where('orders.at_cart', true) // Only get orders still in the cart
            ->where('orders.order_status', 'At Cart') // Orders that are in cart state
            ->orderBy('orders.updated_at', 'desc')
            ->get();

        // Group orders by shop_id
        $groupedOrders = $orders->groupBy('shop_id');

        $building = Building::all();

        // Get all shop details for shops present in the cart
        $shopDetails = Shop::whereIn('id', $groupedOrders->keys())->get()->keyBy('id');

        // Recalculate total in case of discrepancies
        foreach ($orders as $order) {
            $order->total = $order->quantity * $order->price;
            $order->save();
        }

        return view('main.buyer.protocart', compact('orders', 'groupedOrders'));
    }

    public function addToCart(Request $request)
    {
        $userId = $request->session()->get('loginId');

        try {
            DB::beginTransaction();

            $qty = $request->product_qty;
            $price = $request->product_price;
            $total = $price * $qty;

            // Check if the item is already in the cart
            $existingOrder = Order::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->where('order_status', 'At Cart')
                ->where('at_cart', true)
                ->first();

            if ($existingOrder) {
                // If the item is already in the cart, update the quantity and total
                $existingOrder->quantity += $qty;
                $existingOrder->total += $total;
                $existingOrder->updated_at = now();
                $existingOrder->save();
            } else {
                // If the item is not in the cart, create a new order
                $order = new Order;
                $order->user_id = $userId;
                $order->product_id = $request->product_id;
                $order->order_status = 'At Cart';
                $order->quantity = $qty;
                $order->total = $total;
                $order->at_cart = true;
                $order->created_at = now();
                $order->updated_at = now();
                $order->save();
            }

            DB::commit();

            // Store the quantity in the session along with the success message
            return redirect()->back()->with([
                'successAddToCart' => 'Item added to cart!',
                'qty' => $qty
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add product to cart!');
        }
    }

    public function updateQuantity(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        if ($order) {
            // Retrieve the product price from the products table
            $product = Product::find($order->product_id);

            if ($product) {
                $newQuantity = $request->input('product_qty');
                $order->quantity = $newQuantity;
                $order->total = $newQuantity * $product->price;
                $order->save();

                return response()->json([
                    'success' => true,
                    'newSubtotal' => $order->total, // return the updated subtotal
                ]);
            }
        }

        return response()->json(['success' => false]);
    }

    public function removeItem(Request $request, $orderId)
    {
        $userId = $request->session()->get('loginId');

        $order = Order::where('order_status', 'At Cart')
            ->where('user_id', $userId)
            ->where('at_cart', false)
            ->findOrFail($orderId);
        $order->delete();

        return response()->json(['success' => true]);
    }

    public function removeItems(Request $request, $shopId)
    {
        $userId = $request->session()->get('loginId');

        Order::join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.user_id', $userId)
            ->where('products.shop_id', $shopId)
            ->where('order_status', 'At Cart')
            ->where('at_cart', false)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function checkoutOrders(Request $request, $shopId)
    {
        $userId = $request->session()->get('loginId');

        // Decrypt shopId
        $shopId = Crypt::decrypt($shopId);

        // Fetch the shop and its canteen (building)
        $shop = Shop::where('id', $shopId)->first();
        $canteen = Building::where('id', $shop->building_id)->first();

        if (!$shopId) {
            return redirect()->route('landing.page')->with('error', 'Error with the shop, please try again later.');
        }

        if ($shop && $shop->is_reopen == false) {
            return redirect()->route('landing.page')->with('error', 'Shop suddenly closed. Making order to this shop is currently unavailable. Please try again later.');
        }

        // Get only the orders for this user and shop
        $orders = Order::join('products', 'orders.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('shops', 'products.shop_id', 'shops.id')
            ->join('buildings', 'shops.building_id', 'buildings.id')
            ->select(
                'orders.*',
                'products.product_name',
                'products.product_description',
                'products.image',
                'products.price',
                'products.category_id',
                'products.shop_id',
                'products.status',
                'products.is_deleted',
                'categories.type_name as category_name',
                'shops.shop_name',
                'buildings.building_name as designated_canteen'
            )
            ->where('products.status', 'Available')
            ->where('products.shop_id', $shopId)
            ->where('products.is_deleted', false)
            ->where('orders.user_id', $userId)
            ->where('orders.at_cart', true)
            ->where('orders.order_status', 'At Cart')
            ->get();

        if ($orders->first() && $orders->first()->order_status == 'Completed') {
            return redirect()->route('landing.page');
        }

        // Check if the product was marked as 'Unavailable' or 'Deleted'
        if ($orders->first() && ($orders->first()->status == 'Unavailable' || $orders->first()->is_deleted)) {
            return redirect()->route('landing.page')->with('error', 'Product was marked Unavailable by the seller. Please try again soon.');
        }

        // Check if no orders exist for the user in the cart
        if ($orders->isEmpty()) {
            // Redirect to my.cart if no orders are found
            return redirect()->route('landing.page')->with('error', 'Your cart is empty.');
        }

        // Return the checkout view if there are orders
        return view('main.buyer.checkout', compact('orders', 'shop', 'canteen'));
    }

    // Ito ang bago tumatanggap ng qr code submission panis
    public function placeOrder(Request $request, $shopId)
    {
        $userId = $request->session()->get('loginId');
        $user = $request->session()->get('user');
        $shopId = Crypt::decrypt($shopId);

        $shop = Shop::where('id', $shopId)->first();
        if ($shop && $shop->is_reopen == false) {
            return redirect()->route('landing.page')->with('error', 'Shop suddenly closed. Making order is currently unavailable.');
        }

        // Get the length of the shop name
        $length = strlen($shop->shop_name);
        // Extract the first, middle, and last letters
        $firstLetter = $shop->shop_name[0];
        $middleLetter = $shop->shop_name[(int)floor($length / 2)];
        $lastLetter = $shop->shop_name[$length - 1];
        // Concatenate the letters
        $shopCode = $firstLetter . $middleLetter . $lastLetter;

        $dateTime = new DateTime();

        $randomNumber = $dateTime->format('sv');

        // do {
        //     // Generate a random 4-digit number
        //     // $randomNumber = mt_rand(1000, 9999);
        //     $exists = Order::where('order_reference', strtoupper($shopCode) . '-' . 'ORD-' . $randomNumber)
        //         ->where('created_at', now())
        //         ->exists();

        // } while ($exists);

        // Generate unique order reference (this can be any unique string)
        $orderReference = strtoupper($shopCode) . '-' . 'ORD-' . $randomNumber;

        try {
            DB::beginTransaction();

            // Get all orders for this shop that are in the user's cart
            $orders = Order::join('products', 'orders.product_id', 'products.id')
                ->join('shops', 'products.shop_id', 'shops.id')
                ->join('buildings', 'shops.building_id', 'buildings.id')
                ->select(
                    'orders.*',
                    'products.product_name',
                    'products.product_description',
                    'products.image',
                    'products.price',
                    'products.category_id',
                    'products.shop_id',
                    'products.status',
                    'products.is_deleted',
                    'shops.shop_name',
                    'buildings.building_name as designated_canteen'
                )
                ->where('products.status', 'Available')
                ->where('products.shop_id', $shopId)
                ->where('products.is_deleted', false)
                ->where('orders.user_id', $userId)
                ->where('orders.at_cart', true)
                ->where('orders.order_status', 'At Cart')
                ->get();

            if ($orders->first() && $orders->first()->order_status == 'Completed') {
                return redirect()->route('landing.page');
            }

            // Check if no orders exist for the user in the cart
            if ($orders->isEmpty()) {
                return redirect()->route('landing.page');
            }

            $totalAmount = $orders->sum('total');
            $totalAmountInCentavos = $totalAmount * 100; // For GCash and other payment gateways

            if ($totalAmountInCentavos < 2000) {
                return redirect()->back()->with('error', 'Minimum transaction amount is ₱20.00.');
            }

            foreach ($orders as $order) {
                $product = Product::where('id', $order->product_id)->first();
                $product->sold += $order->quantity;
                $product->save();

                // Update order statuses and link payment to orders
                $orderedProducts = new ProductOrder;
                $orderedProducts->product_name = $product->product_name;
                $orderedProducts->product_description = $product->product_description;
                $orderedProducts->price = $product->price;
                $orderedProducts->category_name = Category::where('id', $product->category_id)->first()->type_name;
                $orderedProducts->product_id = $product->id;
                $orderedProducts->created_at = now();
                $orderedProducts->updated_at = now();
                $orderedProducts->save();

                $order->product_orders_id = $orderedProducts->id;
                $order->save();
            }

            // Get the payment method from the request
            $paymentType = $request->input('payment_method');

            // Handle QR payment: Check if the user uploaded the screenshot
            if ($paymentType === 'qr') {
                $paymentId = $request->session()->get('payment_screenshot');
                if (!$paymentId) {
                    return redirect()->back()->with('error', 'Please upload your payment screenshot.');
                }

                // Retrieve the screenshot payment and update the amount
                $payment = Payment::find($paymentId);
                $payment->amount = $totalAmount;
                $payment->payment_status = 'Pending';
                $payment->updated_at = now();
                $payment->save();

                // Update each order's status to "Pending" and assign the order reference
                foreach ($orders as $order) {
                    $order->order_status = 'Pending';
                    $order->order_reference = $orderReference; // Assign the order reference
                    $order->at_cart = false; // Remove from the cart
                    $order->payment_id = $payment->id; // Payment method (optional: if you're handling it)
                    $order->created_at = now();
                    $order->updated_at = now();
                    $order->save();

                    event(new NewOrderPlaced($order));
                }

            } else {
                // Handle GCash and PayPal payments
                $payment = new Payment;
                $payment->payment_id = null;
                $payment->payer_email = $user->email;
                $payment->amount = $totalAmount;
                $payment->currency = 'PHP';
                $payment->payment_type = $paymentType;
                $payment->payment_status = 'Pending';
                $payment->created_at = now();
                $payment->updated_at = now();
                $payment->save();

                $paymentID = $payment->id;

                // Handle GCash Payment
                if ($paymentType === 'gcash') {
                    $client = new Client();
                    $response = $client->post('https://api.paymongo.com/v1/sources', [
                        'auth' => [config('app.paymongo_secret_key'), ''],
                        'json' => [
                            'data' => [
                                'attributes' => [
                                    'amount' => $totalAmountInCentavos, // Amount in centavos
                                    'redirect' => [
                                        'success' => route('track.this.order', ['orderRef' => Crypt::encrypt($orderReference)]),
                                        'failed' => route('payment.failed'),
                                    ],
                                    'type' => $paymentType,
                                    'currency' => 'PHP',
                                ]
                            ]
                        ]
                    ]);

                    $responseData = json_decode($response->getBody(), true);
                    $sourceId = $responseData['data']['id'];
                    $checkoutUrl = $responseData['data']['attributes']['redirect']['checkout_url'];

                    if (!$checkoutUrl) {
                        return redirect()->back()->with('error', 'Failed to get GCash payment URL.');
                    }

                    $payment = Payment::where('id', $paymentID)->first();
                    // Update payment record
                    $payment->update([
                        'payment_id' => $sourceId,
                        'payment_status' => 'Completed',
                        'updated_at' => now(),
                    ]);

                    // Update each order's status to "Pending" and assign the order reference
                    foreach ($orders as $order) {
                        $order->order_status = 'Pending';
                        $order->order_reference = $orderReference; // Assign the order reference
                        $order->at_cart = false; // Remove from the cart
                        $order->payment_id = $payment->id; // Payment method (optional: if you're handling it)
                        $order->created_at = now();
                        $order->updated_at = now();
                        $order->save();
                        event(new NewOrderPlaced($order));
                    }
                }

                // Handle PayPal Payment (for demonstration, you can implement PayPal logic here)
                elseif ($paymentType === 'paypal') {
                    // Initialize PayPal API request
                    $provider = new PayPalClient;
                    $provider->setApiCredentials(config('paypal'));
                    $token = $provider->getAccessToken();
                    $provider->setAccessToken($token);

                    $response = $provider->createOrder([
                        "intent" => "CAPTURE",
                        "purchase_units" => [
                            0 => [
                                "amount" => [
                                    "currency_code" => "PHP",
                                    "value" => number_format($totalAmount, 2, '.', '')
                                ]
                            ]
                        ],
                        "application_context" => [
                            "cancel_url" => route('payment.failed'),
                            "return_url" => route('payment.success', ['orderRef' => Crypt::encrypt($orderReference)])
                        ]
                    ]);

                    if (isset($response['id']) && $response['status'] === 'CREATED') {
                        foreach ($response['links'] as $link) {
                            if ($link['rel'] === 'approve') {
                                $approvalUrl = $link['href'];
                                $payment = Payment::where('id', $paymentID)->first();
                                $payment->payment_id = strval($response['id']);
                                $payment->update();

                                // Update each order's status to "Pending" and assign the order reference
                                foreach ($orders as $order) {
                                    $order->order_status = 'Pending';
                                    $order->order_reference = $orderReference; // Assign the order reference
                                    $order->at_cart = false; // Remove from the cart
                                    $order->payment_id = $payment->id; // Payment method (optional: if you're handling it)
                                    $order->created_at = now();
                                    $order->updated_at = now();
                                    $order->save();
                                    event(new NewOrderPlaced($order));
                                }

                                DB::commit();
                                return redirect($approvalUrl); // Redirect to PayPal approval page
                            }
                        }
                    } else {
                        return redirect()->back()->with('error', $response['message'] ?? 'Something went wrong.');
                    }
                }
            }

            DB::commit();

            // Clear session for payment screenshot after placing the order
            if ($paymentType === 'qr') {
                $request->session()->forget('payment_screenshot');
            }

            // Redirect for GCash payment if applicable
            if ($paymentType === 'gcash' && isset($checkoutUrl)) {
                return redirect($checkoutUrl);
            }

            // Redirect to payment queue for QR payment
            if ($paymentType === 'qr') {
                return redirect()->route('payment.queue', ['orderRef' => Crypt::encrypt($orderReference)]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Failed to place the order. Please try again.');
        }
    }

    public function submitPaymentScreenshot(Request $request, $shopId)
    {
        $userId = $request->session()->get('loginId');
        $user = UserProfile::where('id', $userId)->first();

        $shopId = Crypt::decrypt($shopId);

        $request->validate([
            'payment_screenshot' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for file type and size
        ]);

        if ($request->hasFile('payment_screenshot')) {
            // Store the screenshot
            $screenshotPath = time() . '_' . $user->last_name . '_' . $request->payment_screenshot->getClientOriginalName();
            $request->file('payment_screenshot')->storeAs('payments', $screenshotPath, 'public');

            // Store the screenshot info in the `payments` table
            $payment = new Payment;
            $payment->payment_id = $screenshotPath;
            $payment->payer_email = $request->session()->get('user')->email;
            $payment->amount = 0; // Will be updated when placing the order
            $payment->currency = 'PHP';
            $payment->payment_type = 'qr';
            $payment->payment_status = 'Pending';
            $payment->created_at = now();
            $payment->updated_at = now();
            $payment->save();

            // Store payment ID in session for later use when placing the order
            $request->session()->put('payment_screenshot', $payment->id);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $response = $provider->capturePaymentOrder($request->input('token'));

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // Update the payment status to 'Completed'
            $orderReference = Crypt::decrypt($request->input('orderRef'));
            $payment = Payment::where('payment_id', $response['id'])->first();
            $payment->payment_status = 'Completed';
            $payment->updated_at = now();
            $payment->save();

            // Update order status to 'Completed'
            Order::where('order_reference', $orderReference)->update(['order_status' => 'Pending']);

            return redirect()->route('track.this.order', ['orderRef' => Crypt::encrypt($orderReference)])
                ->with('success', 'Payment successful!');
        }

        return redirect()->route('shop.cart')->with('error', 'Payment failed. Please try again.');
    }

    public function paymentFailed()
    {
        return redirect()->route('shop.cart')->with('error', 'Payment failed. Please try again.');
    }

    public function track_this_order(Request $request, $orderRef)
    {
        $userId = $request->session()->get('loginId');

        // Decrypt orderRef
        $decryptedOrderRef = Crypt::decrypt($orderRef);

        // Query orders and their payment details
        $order = Order::join('payments', 'orders.payment_id', 'payments.id')
            ->select(
                'orders.*',
                'payments.payment_status'
            )
            ->where('orders.at_cart', false)
            ->where('orders.order_status', '!=', 'Completed')
            ->where('orders.user_id', $userId)
            ->where('orders.order_reference', $decryptedOrderRef)
            ->first();  // We expect only one order per reference, so use first()

        // If payment status is 'Rejected', redirect to the cart page with a rejection message
        if ($order && $order->payment_status == 'Rejected') {
            return redirect()->route('shop.cart');
        }

        // Check if the order exists and handle the payment status
        if ($order) {
            if ($order->payment_status == 'Completed') {
                return redirect()->route('track.order', ['orderRef' => $orderRef]);
            } else {
                return redirect()->route('payment.queue', ['orderRef' => $orderRef]);
            }
        }

        // Handle the case where no order was found
        return redirect()->route('landing.page')->with('error', 'Order not found.');
    }

    public function paymentQueue(Request $request, $orderRef)
    {
        $userId = $request->session()->get('loginId');

        // Decrypt orderRef
        $decryptedOrderRef = Crypt::decrypt($orderRef);

        // Query orders and their payment details
        $order = Order::leftjoin('payments', 'orders.payment_id', 'payments.id')
            ->select(
                'orders.*',
                'payments.payment_status'
            )
            ->where('orders.at_cart', false)
            ->where('orders.order_status', '!=', 'Completed')
            ->where('orders.user_id', $userId)
            ->where('orders.order_reference', $decryptedOrderRef)
            ->first();  // We expect only one order per reference, so use first()

        // If the payment status is 'Rejected', redirect to the cart page
        if (!$order) {
            return redirect()->route('landing.page');
        }

        // If the payment status is 'Completed', redirect to the order tracking page
        if ($order && $order->payment_status == 'Completed') {
            return redirect()->route('track.order', ['orderRef' => $orderRef]);
        }

        // If payment is still pending, display the payment queue page
        return view('main.buyer.qpayment');
    }

    public function track_order(Request $request, $orderRef)
    {
        $userId = $request->session()->get('loginId');

        $user = UserProfile::where('id', $userId)->first();

        $orderRef = Crypt::decrypt($orderRef);

        // dd($orderRef);

        // Get all unique orders for this seller's shop
        $orders = Order::join('product_orders', 'orders.product_orders_id', 'product_orders.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('user_profiles', 'orders.user_id', '=', 'user_profiles.id')
            ->join('payments', 'orders.payment_id', 'payments.id')
            ->join('shops', 'products.shop_id', 'shops.id')
            ->join('buildings', 'shops.building_id', 'buildings.id')
            ->select(
                'orders.id',
                'orders.order_reference',
                'orders.created_at',
                'orders.updated_at',
                'orders.total',
                'orders.quantity',
                'orders.order_status',
                'product_orders.product_name',
                'product_orders.price',
                'user_profiles.first_name',
                'user_profiles.last_name',
                'user_profiles.contact_num',
                'payments.payment_id',
                'payments.payment_status',
                'payments.payment_type',
                'shops.shop_name',
                'buildings.building_name as designated_canteen'
            )
            ->where('orders.at_cart', false)
            ->where('orders.order_status', '!=', 'Completed')
            ->where('orders.order_reference', $orderRef)
            ->where('orders.user_id', $userId)
            ->orderBy('orders.updated_at', 'desc')
            ->groupBy('orders.order_reference') // Group by the unique order_reference
            ->get();

        if ($orders->first() && $orders->first()->order_status == 'Completed') {
            Session::flash('orderCompleted', true);
            Session::flash('orderReference', $orderRef);
            return redirect()->route('landing.page');
        }

        if ($orders->isEmpty()) {
            // dd($orders);
            Session::flash('orderCompleted', true);
            Session::flash('orderReference', $orderRef);
            return redirect()->route('landing.page');
        }

        foreach ($orders as $order) {
            // Fetch products for each order
            $order->products = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->join('product_orders', 'orders.product_orders_id', 'product_orders.id')
                ->join('categories', 'products.category_id', 'categories.id')
                ->select(
                    'products.id',
                    'product_orders.product_name',
                    'products.image',
                    'product_orders.price',
                    'orders.quantity',
                    'orders.total',
                    'product_orders.category_name'
                )
                ->where('orders.order_reference', $order->order_reference)
                ->get();
        }

        return view('main.buyer.trackorder', compact('orders', 'user', 'orderRef'));
    }

    public function order_history(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $orders = Order::join('product_orders', 'orders.product_orders_id', 'product_orders.id')
            ->join('products', 'orders.product_id', 'products.id')
            ->join('shops', 'products.shop_id', 'shops.id')
            ->join('buildings', 'shops.building_id', 'buildings.id')
            ->select(
                'orders.order_reference',
                'orders.created_at',
                'orders.total',
                'orders.quantity',
                'orders.order_status',
                'shops.shop_name',
                'buildings.building_name as designated_canteen'
            )
            ->where('orders.user_id', $userId)
            ->where('orders.order_status', 'Completed')
            ->orderBy('orders.updated_at', 'desc')
            ->groupBy('orders.order_reference')
            ->get();

        foreach ($orders as $order) {
            // Fetch products for each order
            $order->products = Order::join('product_orders', 'orders.product_orders_id', 'product_orders.id')
                ->join('products', 'orders.product_id', 'products.id')
                ->select(
                    'product_orders.product_name',
                    'products.image',
                    'product_orders.price',
                    'orders.quantity',
                    'orders.total',
                    'product_orders.category_name'
                )
                ->where('orders.order_reference', $order->order_reference)
                ->get();
        }

        return view('main.buyer.order-history', compact('orders'));
    }

    // REVIEW COMPLETED ORDER ☜(ﾟヮﾟ☜)
    public function store_review(Request $request)
    {
        $userId = $request->session()->get('loginId');

        try {
            // Start transaction
            DB::beginTransaction();

            // Step 1: Validate the incoming review data
            $request->validate([
                'order_reference' => 'required|string', // Validate the order reference
                'review_text' => 'required|string|max:255',
                'rating' => 'required|integer|between:1,5',
            ]);

            // Step 2: Find the actual order by its reference code
            $order = Order::where('order_reference', $request->input('order_reference'))
                ->where('user_id', $userId) // Ensure the order belongs to the logged-in user
                ->first();

            if (!$order) {
                // If the order doesn't exist or doesn't belong to this user, return with an error
                return redirect()->back()->with('error', 'Invalid order reference or permission denied!');
            }

            // Step 3: Fetch all products associated with this order
            $products = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->where('orders.order_reference', $order->order_reference)
                ->select('products.id as product_id') // Select all product IDs
                ->get();

            if ($products->isEmpty()) {
                // If no products are found for the order, return with an error
                return redirect()->back()->with('error', 'No products found for this order.');
            }

            // Step 4: Loop through each product and create a review for each one
            foreach ($products as $product) {
                // Check if a review already exists for this order and product (optional)
                $existingReview = Review::where('order_id', $order->id)
                    ->where('product_id', $product->product_id)
                    ->where('user_id', $userId)
                    ->first();

                if (!$existingReview) {
                    // Step 5: Save the review in the database for each product
                    $review = new Review;
                    $review->order_id = $order->id; // Use the actual order ID
                    $review->product_id = $product->product_id; // Store the product ID
                    $review->review_text = $request->input('review_text');
                    $review->rating = $request->input('rating');
                    $review->user_id = $userId;
                    $review->created_at = now();
                    $review->updated_at = now();
                    $review->save();
                }
            }

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('landing.page')->with('success', 'Thank you for your review!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of any errors
            DB::rollBack();

            // Log the error for debugging
            Log::error('Review Submission Error: ' . $e->getMessage());

            // Return back with a general error message
            return redirect()->back()->with('error', 'There was an issue submitting your review. Please try again.');
        }
    }

    //DISPLAY REVIEWS OF EACH PRODUCT IN THE MODAL
    public function getProductReviews($productId)
    {
        // Fetch reviews for the specified product, along with the user's username
        $reviews = Review::join('user_profiles', 'reviews.user_id', '=', 'user_profiles.id')
            ->where('reviews.product_id', $productId)
            ->select('reviews.*', 'user_profiles.username') // Select reviews and username
            ->get();

        // Return the reviews as JSON response to be used in the frontend
        return response()->json($reviews);
    }
}
