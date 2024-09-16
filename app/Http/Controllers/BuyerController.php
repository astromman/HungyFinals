<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shop;
use App\Models\UserProfile;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

class BuyerController extends Controller
{
    //
    public function landing_page(Request $request)
    {
        $canteens = Building::all();
        $products = Product::all();

        return view('main.buyer.landingpage', compact('canteens', 'products'));
    }

    public function about_us_page()
    {
        return view('main.buyer.about');
    }

    public function my_favorites(Request $request)
    {
        return view('main.buyer.favorites');
    }

    public function my_profile(Request $request)
    {
        return view('main.buyer.profile');
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

        // Group products by category
        $groupedProducts = $products->groupBy('category_name');

        return view('main.buyer.shop-menu', compact('shops', 'products', 'groupedProducts'));
    }

    // CART
    public function shop_cart(Request $request)
    {
        $userId = $request->session()->get('loginId');

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
                'categories.type_name',
                'shops.shop_name',
                'buildings.building_name as designated_canteen'
            )
            ->where('products.status', 'Available')
            ->where('is_deleted', false)
            ->where('orders.user_id', $userId)
            ->where('orders.at_cart', true)
            ->where('orders.order_status', 'At Cart')
            ->orderBy('orders.updated_at',  'desc')
            ->get();

        // Group orders by shop_id
        $groupedOrders = $orders->groupBy('shop_id');

        $building = Building::all();

        // Get all shop details for shops present in the cart
        $shopDetails = Shop::whereIn('id', $groupedOrders->keys())->get()->keyBy('id');

        $shop = Shop::where('id', $groupedOrders->keys())->first();

        // Recalculate total in case of discrepancies
        foreach ($orders as $order) {
            $order->total = $order->quantity * $order->price;
            $order->save();
        }

        return view('main.buyer.protocart', compact('orders', 'groupedOrders', 'shop'));
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
                'success' => 'Item added to cart!',
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

    public function removeItem($orderId)
    {
        $order = Order::where('order_status', 'At Cart')
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
            abort(404, 'Page not Found');
        }

        // Get only the orders for this user and shop
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
            ->where('is_deleted', false)
            ->where('orders.user_id', $userId)
            ->where('orders.at_cart', true)
            ->where('orders.order_status', 'At Cart')
            ->get();

        // Check if no orders exist for the user in the cart
        if ($orders->isEmpty()) {
            // Redirect to my.cart if no orders are found
            return redirect()->route('shop.cart')->with('error', 'Your cart is empty.');
        }

        // Return the checkout view if there are orders
        return view('main.buyer.checkout', compact('orders', 'shop', 'canteen'));
    }

    public function placeOrder(Request $request, $shopId)
    {
        $userId = $request->session()->get('loginId');
        $user = $request->session()->get('user');

        $shopId = Crypt::decrypt($shopId);

        $shopName = Shop::where('id', $shopId)->first()->shop_name;

        // Get the length of the shop name
        $length = strlen($shopName);
        // Extract the first, middle, and last letters
        $firstLetter = $shopName[0];
        $middleLetter = $shopName[(int)floor($length / 2)];
        $lastLetter = $shopName[$length - 1];
        // Concatenate the letters
        $shopCode = $firstLetter . $middleLetter . $lastLetter;

        // $dateToday = date('dmY');

        do {
            // Generate a random 4-digit number
            $randomNumber = mt_rand(1000, 9999);

            $exists = Order::where('order_reference', strtoupper($shopCode) . '-' . 'ORD-' . $randomNumber)
                ->where('created_at', now())
                ->exists();
        } while ($exists);

        // Generate unique order reference (this can be any unique string)
        $orderReference = strtoupper($shopCode) . '-' . 'ORD-' . $randomNumber;

        $orderRef = Crypt::encrypt($orderReference);

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
                ->where('is_deleted', false)
                ->where('orders.user_id', $userId)
                ->where('orders.at_cart', true)
                ->where('orders.order_status', 'At Cart')
                ->get();

            $totalAmount = $orders->sum('total');

            $totalAmountInCentavos = $totalAmount * 100;
            // dd($totalAmountInCentavos);
            if ($totalAmountInCentavos < 2000) {
                return redirect()->back()->with('error', 'Minimum transaction amount is ₱20.00.');
            }

            foreach ($orders as $order) {
                $product = Product::where('id', $order->product_id)->first();
                $product->sold += $order->quantity;
                $product->save();
            }

            $paymentType = $request->payment_type;

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

            // Make a request to PayMongo to create a GCash payment source
            $client = new Client();
            $response = $client->post('https://api.paymongo.com/v1/sources', [
                'auth' => [config('app.paymongo_secret_key'), ''],
                'json' => [
                    'data' => [
                        'attributes' => [
                            'amount' => $totalAmountInCentavos, // Amount in centavos
                            'redirect' => [
                                'success' => route('payment.success', ['orderRef' => $orderRef]),
                                'failed' => route('payment.failed'),
                            ],
                            'type' => $paymentType,
                            'currency' => $payment->currency,
                        ]
                    ]
                ]
            ]);

            // Parse the response
            $responseData = json_decode($response->getBody(), true);
            $sourceId = $responseData['data']['id'];
            $checkoutUrl = $responseData['data']['attributes']['redirect']['checkout_url'];

            if (!$checkoutUrl) {
                return redirect()->back()->with('error', 'Failed to get GCash payment URL.');
            }

            // Update the payment record with PayMongo's source ID
            $payment->update([
                'payment_id' => $sourceId,
                'payment_status' => 'Completed',
                'updated_at' => now(),
            ]);

            // Update each order's status to "Placed" and assign the order reference
            foreach ($orders as $order) {
                $order->order_status = 'Pending'; // Update status to "Placed"
                $order->order_reference = $orderReference; // Assign the order reference
                $order->at_cart = false; // Remove from the cart
                $order->payment_id = $payment->id; // Payment method (optional: if you're handling it)

                $order->updated_at = now();
                $order->save();
            }

            DB::commit();

            // Redirect the user to PayMongo's GCash checkout URL
            return redirect($checkoutUrl);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Failed to place the order. Please try again.');
        }
    }

    public function paymentSuccess($orderRef)
    {
        return redirect()->route('track.order', ['orderRef' => $orderRef])->with('success', 'Payment successful! Your order has been placed.');
    }

    public function paymentFailed(Request $request)
    {
        return redirect()->route('shop.cart')->with('error', 'Payment failed. Please try again.');
    }

    public function track_this_order($orderRef)
    {
        return redirect()->route('track.order', ['orderRef' => $orderRef]);
    }

    public function track_order(Request $request, $orderRef)
    {
        $userId = $request->session()->get('loginId');

        $user = UserProfile::where('id', $userId)->first();

        $orderRef = Crypt::decrypt($orderRef);

        // Get all unique orders for this seller's shop
        $orders = Order::join('products', 'orders.product_id', '=', 'products.id')
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
                'user_profiles.first_name',
                'user_profiles.last_name',
                'user_profiles.contact_num',
                'payments.payment_id',
                'payments.payment_status',
                'payments.payment_type',
                'shops.shop_name',
                'buildings.building_name as designated_canteen'
            )
            // Filter orders by the shop_id
            // ->where('products.shop_id', $shopId) 
            ->where('orders.at_cart', false)
            ->where('orders.order_status', '!=', 'At Cart')
            ->where('orders.order_status', '!=', 'Completed')
            ->where('orders.order_reference', $orderRef)
            ->orderBy('orders.updated_at', 'desc')
            ->groupBy('orders.order_reference') // Group by the unique order_reference
            ->get();

        if($orders->isEmpty()) {
            return redirect()->route('landing.page')->with('error', 'Order not found.');
        }

        foreach ($orders as $order) {
            // Fetch products for each order
            $order->products = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', 'categories.id')
                ->select(
                    'products.id',
                    'products.product_name',
                    'products.image',
                    'products.price',
                    'orders.quantity',
                    'orders.total',
                    'categories.type_name'
                )
                ->where('orders.order_reference', $order->order_reference)
                ->get();
        }

        return view('main.buyer.trackorder', compact('orders', 'user'));
    }
}
