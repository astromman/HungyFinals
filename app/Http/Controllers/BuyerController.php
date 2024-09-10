<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shop;
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
            ->join('shops', 'products.shop_id', 'shops.id')
            ->join('buildings', 'shops.building_id', 'buildings.id')
            ->select(
                'orders.*',
                'products.*',
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

        // Recalculate total in case of discrepancies
        foreach ($orders as $order) {
            $order->total = $order->quantity * $order->price;
            $order->save();
        }

        return view('main.buyer.protocart', compact('orders', 'groupedOrders', 'shopDetails'));
    }

    // public function shop_cart(Request $request)
    // {
    //     $userId = $request->session()->get('loginId');

    //     // Fetch orders for the logged-in user, with related products, shop, and building data
    //     $orders = Order::join('products', 'orders.product_id', 'products.id')
    //         ->join('shops', 'products.shop_id', 'shops.id')
    //         ->join('buildings', 'shops.building_id', 'buildings.id')
    //         ->select(
    //             'orders.*',
    //             'products.*',
    //             'products.product_name',
    //             'products.product_description',
    //             'products.image',
    //             'products.price',
    //             'products.category_id',
    //             'products.shop_id',
    //             'products.status',
    //             'products.is_deleted',
    //             'shops.shop_name',
    //             'buildings.building_name as designated_canteen'
    //         )
    //         ->where('products.status', 'Available')
    //         ->where('is_deleted', false)
    //         ->where('orders.user_id', $userId)
    //         ->where('orders.at_cart', true)
    //         ->where('orders.order_status', 'At Cart')
    //         ->orderBy('orders.updated_at',  'desc')
    //         ->get();

    //     // Group orders by shop_id
    //     $groupedOrders = $orders->groupBy('products.shop_id');

    //     // Get all shop details for shops present in the cart
    //     $shopDetails = Shop::whereIn('id', $groupedOrders->keys())->get()->keyBy('id');

    //     return view('main.buyer.protocart', compact('orders', 'groupedOrders', 'shopDetails'));
    // }


    // public function shop_cart(Request $request)
    // {
    //     $userId = $request->session()->get('loginId'); // Make sure loginId is properly stored in session.

    //     // Fetch orders for the logged-in user, with product, shop, and building relationships
    //     $orders = Order::with(['product.shop.building'])
    //         ->where('orders.user_id', $userId)
    //         ->where('orders.at_cart', true)
    //         ->where('orders.order_status', 'At Cart')
    //         ->orderBy('orders.updated_at', 'desc')
    //         ->get();

    //     // Group orders by shop_id
    //     $groupedOrders = $orders->groupBy('product.shop_id');

    //     // Get all shop details for shops present in the cart
    //     $shopDetails = Shop::whereIn('id', $groupedOrders->keys())->get()->keyBy('id');

    //     return view('main.buyer.protocart', compact('orders', 'groupedOrders', 'shopDetails'));
    // }

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
                    'newSubtotal' => $order->total,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }

    public function removeItem($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->delete();

        return response()->json(['success' => true]);
    }

    public function removeItems(Request $request, $shopId)
    {
        $userId = $request->session()->get('loginId');

        Order::join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.user_id', $userId)
            ->where('products.shop_id', $shopId)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function checkoutOrders(Request $request, $shopId)
    {
        $userId = $request->session()->get('loginId');

        $shopId = Crypt::decrypt($shopId);

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
            if ($totalAmountInCentavos < 2000) {
                return redirect()->back()->with('error', 'Minimum transaction amount is ₱20.00.');
            }

            $payment = new Payment;
            $payment->payment_id = null;
            $payment->payer_email = $user->email;
            $payment->amount = $totalAmount;
            $payment->currency = 'PHP';
            $payment->payment_status = 'Pending';
            $payment->created_at = now();
            $payment->updated_at = now();
            $payment->save();

            // Make a request to PayMongo to create a GCash payment source
            $client = new Client();
            $response = $client->post('https://api.paymongo.com/v1/sources', [
                'auth' => [env('PAYMONGO_SECRET_KEY'), ''],
                'json' => [
                    'data' => [
                        'attributes' => [
                            'amount' => $totalAmountInCentavos, // Amount in centavos
                            'redirect' => [
                                'success' => route('payment.success'),
                                'failed' => route('payment.failed'),
                            ],
                            'type' => 'gcash',
                            'currency' => 'PHP'
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

    public function paymentSuccess(Request $request)
    {
        return redirect()->route('shop.cart')->with('success', 'Payment successful! Your order has been placed.');
    }

    public function paymentFailed(Request $request)
    {
        return redirect()->route('shop.cart')->with('error', 'Payment failed. Please try again.');
    }
}
