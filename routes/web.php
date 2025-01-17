<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\CommonUtilityController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UnverifiedController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Translation\Loader\CsvFileLoader;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/logout', [LoginController::class, 'logout'])->name('user.logout');

Route::get('/test', function() {
    return view('main.manager.application_status_email');
});

Route::group([
    'prefix' => '/',
    'middleware' => [
        'web',
        'guest',
    ]
], function () {
    Route::get('/', [LoginController::class, 'index'])->name('guest.page');

    Route::get('/login', [LoginController::class, 'login_form'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login_post'])->name('login.post');

    Route::get('/register', [LoginController::class, 'register_form'])->name('register.form');
    Route::post('/register', [LoginController::class, 'register_post'])->name('register.post');

    Route::get('/_about-us', [BuyerController::class, 'gestAboutPage'])->name('guest.about.us.page');

    Route::get('/verify-otp', [LoginController::class, 'showOtpForm'])->name('show.otp.form');
    Route::post('/verify-otp', [LoginController::class, 'verifyOtp'])->name('verify.otp.post');
    Route::get('/resend-otp', [LoginController::class, 'resendOtp'])->name('resend.otp');

    Route::get('/forgot-password', [LoginController::class, 'forgot_pass_form'])->name('forgot.pass.form');
    Route::post('/forgot-password', [LoginController::class, 'sendResetLinkEmail'])->name('forgot.pass.email');

    Route::get('/otp-verification', [LoginController::class, 'showOtpVerificationForm'])->name('otp.verification.form');
    Route::post('/otp-verification', [LoginController::class, 'verifyResetOtp'])->name('verify.reset.otp');
    Route::get('/new-password', [LoginController::class, 'showNewPasswordForm'])->name('new.password.form');
    Route::post('/new-password', [LoginController::class, 'resetPassword'])->name('reset.password');
    Route::get('/helloworld', [CommonUtilityController::class, 'helloWorld']);

    Route::get('/auth/google/redirect', [LoginController::class, 'googleRedirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [LoginController::class, 'googleCallback'])->name('google.callback');
});

Route::group([
    'prefix' => '',
    'middleware' =>
    [
        'web',
        'custom.auth',
        'role:Buyer'
    ]
], function () {
    Route::get('/homepage', [BuyerController::class, 'landing_page'])->name('landing.page');

    Route::get('/about-us', [BuyerController::class, 'about_us_page'])->name('about.us.page');

    Route::get('/my-favorites', [BuyerController::class, 'my_favorites'])->name('my.favorites');
    Route::post('/toggle-favorite/{productId}', [BuyerController::class, 'toggleFavorite'])->name('toggle.favorite');
    Route::post('/favorites/add', [BuyerController::class, 'addToFavorites'])->name('favorites.add');
    //REMOVE FROM FAVORITES
    Route::delete('/favorites/remove/{id}', [BuyerController::class, 'removeFavorite'])->name('favorites.remove');

    //SEARCH FOR SHOPS AND ITEMS
    Route::get('/search', [BuyerController::class, 'searchItem'])->name('searchItem');

    Route::get('/my-profile', [BuyerController::class, 'my_profile'])->name('buyer.my.profile');
    Route::post('/my-profile/update-profile', [BuyerController::class, 'update_profile'])->name('buyer.update.profile');
    Route::get('/change-password', [BuyerController::class, 'buyer_change_password'])->name('buyer.change.password');
    Route::post('/change-password', [BuyerController::class, 'update_password'])->name('buyer.update.password');

    Route::get('/canteen/visit/{id}/{building_name}', [BuyerController::class, 'visit_canteen'])->name('visit.canteen');

    Route::get('/shops', [BuyerController::class, 'shops_list'])->name('shops.list');

    Route::get('/shops/visit/{id}/{shop_name}', [BuyerController::class, 'visit_shop'])->name('visit.shop');

    Route::get('/my-cart', [BuyerController::class, 'shop_cart'])->name('shop.cart');
    Route::post('/cart/add', [BuyerController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update-quantity/{orderId}', [BuyerController::class, 'updateQuantity'])->name('update.quantity');
    Route::delete('/cart/remove/{orderId}', [BuyerController::class, 'removeItem'])->name('remove.item');
    Route::delete('/cart/remove-items/{shopId}', [BuyerController::class, 'removeItems'])->name('remove.items');

    Route::get('/checkout/{shopId}', [BuyerController::class, 'checkoutOrders'])->name('checkout.orders');
    Route::post('/seller/notify-new-order', [BuyerController::class, 'notifyNewOrder'])->name('seller.notify.new.order');
    Route::post('/submit-payment-screenshot/{shopId}', [BuyerController::class, 'submitPaymentScreenshot'])->name('submit.payment.screenshot');
    Route::post('/checkout/place-order/{shopId}', [BuyerController::class, 'placeOrder'])->name('place.order');
    Route::get('/payment/success', [BuyerController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/failed', [BuyerController::class, 'paymentFailed'])->name('payment.failed');

    Route::get('/payment-queue/{orderRef}', [BuyerController::class, 'paymentQueue'])->name('payment.queue');

    Route::get('/track-order/{orderRef}', [BuyerController::class, 'track_order'])->name('track.order');
    Route::post('/track-order/{orderRef}', [BuyerController::class, 'track_this_order'])->name('track.this.order');

    Route::get('/order-history', [BuyerController::class, 'order_history'])->name('buyer.order.history');

    //MODAL POP UP FOR REVIEWS IN LANDING PAGE
    Route::post('/submit-review', [BuyerController::class, 'store_review'])->name('submit.review');

    //DISPLAY PRODUCT REVIEWS IN THEIR MODAL
    Route::get('/get-reviews/{productId}', [BuyerController::class, 'getProductReviews']);
});

Route::group([
    'prefix' => 'seller/u',
    'middleware' =>
    [
        'web',
        'custom.auth',
        'role:Unverified'
    ]
], function () {
    Route::get('/verification', [UnverifiedController::class, 'resubmission_form'])->name('resubmission.form');
    Route::post('/verification', [UnverifiedController::class, 'submit_application'])->name('submit.application');
    Route::post('/verification/resubmit', [UnverifiedController::class, 'resubmit_application'])->name('resubmit.application');

    Route::get('/change-password', [UnverifiedController::class, 'unv_change_password'])->name('unv.change.password');
    Route::post('/change-password', [UnverifiedController::class, 'update_password'])->name('unv.update.password');
});

Route::group([
    'prefix' => 'seller/v',
    'middleware' =>
    [
        'web',
        'custom.auth',
        'role:Seller',
    ]
], function () {
    Route::get('/dashboard', [SellerController::class, 'seller_dashboard'])->name('seller.dashboard');

    Route::post('/clear-modal-flag', [SellerController::class, 'clearModalFlag'])->name('clear.modal.flag');

    Route::get('/change-password', [SellerController::class, 'seller_change_password'])->name('seller.change.password');
    Route::post('/change-password', [SellerController::class, 'update_password'])->name('seller.update.password');
    Route::post('/update-store-status', [SellerController::class, 'update_shop_status'])->name('update.shop.status');

    Route::get('/my-shop/view-mode', [SellerController::class, 'shop_view_mode'])->name('shop.view.mode');

    Route::get('/my-shop/edit-details', [SellerController::class, 'shop_update_details'])->name('shop.update.details');
    Route::post('/my-shop/edit-details', [SellerController::class, 'update_details'])->name('shop.updated.details');

    Route::get('/my-products', [SellerController::class, 'my_products_table'])->name('my.products.table');
    Route::get('/add-products', [SellerController::class, 'my_products'])->name('my.products');
    Route::post('/add-products', [SellerController::class, 'add_products'])->name('add.products');
    Route::post('/edit-products', [SellerController::class, 'edit_products'])->name('edit.products');
    Route::delete('/delete-products/{id}', [SellerController::class, 'delete_products'])->name('delete.products');

    Route::get('/add-categories', [SellerController::class, 'product_categories'])->name('product.categories');
    Route::post('/add-categories', [SellerController::class, 'add_category'])->name('add.category');
    Route::get('/edit-categories/{id}', [SellerController::class, 'edit_button_category'])->name('edit.button.category');
    Route::post('/edit-categories/{id}', [SellerController::class, 'edit_category'])->name('edit.category');
    Route::delete('/delete-categories/{id}', [SellerController::class, 'delete_category'])->name('delete.category');

    Route::get('/my-orders', [SellerController::class, 'my_orders'])->name('my.orders');
    Route::get('/seller/check-new-orders', [SellerController::class, 'checkNewOrders'])->name('seller.check.new.orders');
    Route::post('/update-order/{orderRef}', [SellerController::class, 'updateOrder'])->name('update.order');
    Route::post('/confirm-payment', [SellerController::class, 'confirmPayment'])->name('confirm.payment');
    Route::post('/reject-payment', [SellerController::class, 'rejectPayment'])->name('reject.payment');


    Route::get('/order-history', [SellerController::class, 'order_history'])->name('seller.order.history');

    Route::get('/my-shop/verification', [SellerController::class, 'verified'])->name('verified');
});

Route::group([
    'prefix' => 'manager',
    'middleware' =>
    [
        'web',
        'custom.auth',
        'role:Manager'
    ]
], function () {
    Route::get('/', [ManagerController::class, 'manager_dashboard'])->name('manager.dashboard');

    Route::get('/logs', [ManagerController::class, 'audit_logs'])->name('manager.audit.logs');

    Route::get('/my-profile', [ManagerController::class, 'manager_my_profile'])->name('manager.my.profile');
    Route::post('my-profile/update-profile', [ManagerController::class, 'update_profile'])->name('manager.update.profile');
    Route::get('my-profile/change-password', [ManagerController::class, 'manager_change_password'])->name('manager.change.password');
    Route::post('my-profile/change-password', [ManagerController::class, 'update_password'])->name('manager.update.password');

    Route::get('/concessionaires-account/add', [ManagerController::class, 'concessionaires_account'])->name('concessionaires.account');
    Route::post('/concessionaires-account/add', [ManagerController::class, 'post_concessionaires_account'])->name('post.concessionaires.account');
    Route::get('/concessionaires-account/edit/{userId}', [ManagerController::class, 'edit_button_cons_account'])->name('edit.button.cons.account');
    Route::post('/concessionaires-account/edit/{userId}', [ManagerController::class, 'edit_cons_account'])->name('edit.cons.account');
    Route::delete('/concessionaires-account/delete/{id}', [ManagerController::class, 'delete_concessionaires_account'])->name('delete.concessionaires.account');

    Route::get('/applications', [ManagerController::class, 'shops_applications'])->name('shops.applications');
    Route::patch('/applications/approve/{id}', [ManagerController::class, 'approve_shops_application'])->name('approve.shops.application');
    Route::patch('/applications/reject/{id}', [ManagerController::class, 'reject_shops_application'])->name('reject.shops.application');
    Route::get('/applications-history', [ManagerController::class, 'applications_history'])->name('applications.history');
});

Route::group([
    'prefix' => 'admin',
    'middleware' =>
    [
        'web',
        'custom.auth',
        'role:Admin'
    ]
], function () {
    Route::get('/', [AdminController::class, 'admin_dashboard'])->name('admin.dashboard');

    Route::get('/logs', [AdminController::class, 'audit_logs'])->name('admin.audit.logs');

    Route::get('/buyers-account', [AdminController::class, 'buyers_account'])->name('buyers.account');

    Route::get('/my-profile', [AdminController::class, 'admin_my_profile'])->name('admin.my.profile');
    Route::post('my-profile/update-profile', [AdminController::class, 'update_profile'])->name('admin.update.profile');
    Route::get('my-profile/change-password', [AdminController::class, 'admin_change_password'])->name('admin.change.password');
    Route::post('my-profile/change-password', [AdminController::class, 'update_password'])->name('admin.update.password');

    Route::get('/canteen-management', [AdminController::class, 'manage_building'])->name('manage.building');
    Route::post('/canteen-management', [AdminController::class, 'post_manage_building'])->name('post.manage.building');
    Route::get('/canteen-management/edit/{id}/{building_name}', [AdminController::class, 'edit_button_building'])->name('edit.button.building');
    Route::post('/canteen-management/edit/{id}/{building_name}', [AdminController::class, 'edit_building'])->name('edit.building');
    Route::delete('/canteen-management/delete/{id}', [AdminController::class, 'delete_building'])->name('delete.building');

    Route::get('/managers-accounts', [AdminController::class, 'manager_account'])->name('manager.account');
    Route::post('/managers-accounts', [AdminController::class, 'post_manager_account'])->name('post.manager.account');
    Route::get('/managers-accounts/edit/{id}', [AdminController::class, 'edit_button_manager_account'])->name('edit.button.manager.account');
    Route::put('/managers-accounts/edit/{id}', [AdminController::class, 'edit_manager_account'])->name('edit.manager.account');
    Route::delete('/managers-accounts/delete/{id}', [AdminController::class, 'delete_manager'])->name('delete.manager');
});

// images when deployed
Route::get('/foo', function () {
    Artisan::call('storage:link');
});

Route::fallback(function () {
    return ('404 lods');
})->name('notFound');