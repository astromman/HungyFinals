<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function shop_cart(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $orders = Order::where('user_id', $userId)->get();

        return view('main.buyer.protocart', compact('orders'));
    }

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

    public function addToCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_price = $request->input('product_price');
        $product_qty = $request->input('product_qty');

        dd($product_id);
    }
}
