<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ManageController;
use App\Http\Controllers\Admin\ManageOrdersController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Client\CouponController;
use App\Http\Controllers\Client\RestaurantController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'Index'])->name('index');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.profile');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/change/password', [UserController::class, 'UserChangePassword'])->name('change.password');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/store', [UserController::class, 'UserProfileStore'])->name('profile.store');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');

    Route::get('/all/wishlist', [HomeController::class, 'AllWishlist'])->name('all.wishlist');
    Route::get('/remove/wishlist/{id}', [HomeController::class, 'RemoveWishlist'])->name('remove.wishlist');

    Route::controller(ManageOrdersController::class)->group(function () {
        Route::get('/user/orders/list', 'UserOrdersList')->name('user.order.list');
        Route::get('/user/order/details/{id}', 'UserOrderDetails')->name('user.order.details');
        Route::get('/user/invoice/download/{id}', 'UserInvoiceDownload')->name('user.invoice.download');
    });

});

require __DIR__.'/auth.php';

//ADMIN routes
Route::middleware('admin')->group(function () {
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
});

Route::get('/admin/forget_password', [AdminController::class, 'AdminForgetPassword'])->name('admin.forget_password');
Route::get('/admin/reset_password/{token}/{email}', [AdminController::class, 'AdminResetPassword']);
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

Route::post('/admin/login_submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login_submit');
Route::post('/admin/password_submit', [AdminController::class, 'AdminPasswordSubmit'])->name('admin.password_submit');
Route::post('/admin/reset_password_submit', [AdminController::class, 'AdminResetPasswordSubmit'])->name('admin.reset_password_submit');

//CLIENT routes
Route::middleware('client')->group(function () {
    Route::get('/client/change/password', [ClientController::class, 'ClientChangePassword'])->name('client.change.password');
    Route::get('/client/dashboard', [ClientController::class, 'ClientDashboard'])->name('client.dashboard');
    Route::get('/client/profile', [ClientController::class, 'ClientProfile'])->name('client.profile');
    Route::post('/client/password/update', [ClientController::class, 'ClientPasswordUpdate'])->name('client.password.update');
    Route::post('/client/profile/store', [ClientController::class, 'ClientProfileStore'])->name('client.profile.store');
});

Route::get('/client/login', [ClientController::class, 'ClientLogin'])->name('client.login');
Route::get('/client/logout', [ClientController::class, 'ClientLogout'])->name('client.logout');
Route::get('/client/register', [ClientController::class, 'ClientRegister'])->name('client.register');

Route::post('/client/register.submit', [ClientController::class, 'ClientRegisterSubmit'])->name('client.register.submit');
Route::post('/client/login_submit', [ClientController::class, 'ClientLoginSubmit'])->name('client.login_submit');

//ALL ADMIN CATEGORY routes
Route::middleware('admin')->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::get('/all/category', 'AllCategory')->name('all.category');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::post('/store/category', 'StoreCategory')->name('store.category');
        Route::post('/update/category', 'UpdateCategory')->name('update.category');
    });
});

//ALL ADMIN CITY routes
Route::middleware('admin')->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/city', 'AllCity')->name('all.city');
        Route::get('/delete/city/{id}', 'DeleteCity')->name('delete.city');
        Route::get('/edit/city/{id}', 'EditCity');
        Route::post('/store/city', 'StoreCity')->name('city.store');
        Route::post('/update/city', 'UpdateCity')->name('city.update');
    });

    Route::controller(ManageController::class)->group(function () {
        Route::get('/admin/add/product', 'AdminAddProduct')->name('admin.add.product');
        Route::get('/admin/all/product', 'AdminAllProduct')->name('admin.all.product');
        Route::get('/admin/delete/product/{id}', 'AdminDeleteProduct')->name('admin.delete.product');
        Route::get('/admin/edit/product/{id}', 'AdminEditProduct')->name('admin.edit.product');
        Route::post('/admin/store/product', 'AdminStoreProduct')->name('admin.product.store');
        Route::post('/admin/update/product', 'AdminUpdateProduct')->name('admin.product.update');
    });

    Route::controller(ManageController::class)->group(function () {
        Route::get('/approved/restaurant', 'ApprovedRestaurant')->name('approved.restaurant');
        Route::get('/clientChangeStatus', 'ClientChangeStatus');
        Route::get('/pending/restaurant', 'PendingRestaurant')->name('pending.restaurant');
    });

    Route::controller(ManageController::class)->group(function () {
        Route::get('/all/banner', 'AllBanner')->name('all.banner');
        Route::get('/edit/banner/{id}', 'EditBanner');
        Route::post('/banner/store', 'StoreBanner')->name('banner.store');
        Route::post('/banner/update', 'UpdateBanner')->name('banner.update');
        Route::get('/delete/banner/{id}', 'DeleteBanner')->name('delete.banner');
    });

    Route::controller(ManageOrdersController::class)->group(function () {
        Route::get('/confirmed/orders', 'ConfirmedOrders')->name('confirmed.orders');
        Route::get('/delivered/orders', 'DeliveredOrders')->name('delivered.orders');
        Route::get('/admin/order/details/{id}', 'AdminOrderDetails')->name('admin.order_details');
        Route::get('/pending/orders', 'PendingOrders')->name('pending.orders');
        Route::get('/processing/orders', 'ProcessingOrders')->name('processing.orders');
        Route::get('/set/status/confirm/{id}', 'SetStatusConfirm')->name('setStatusConfirm');
        Route::get('/set/status/processing/{id}', 'SetStatusProcessing')->name('setStatusProcessing');
        Route::get('/set/status/delivered/{id}', 'SetStatusDelivered')->name('setStatusDelivered');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/admin/all/reports', 'AdminAllReports')->name('admin.all.reports');
        Route::post('/admin/search/bydate', 'AdminSearchByDate')->name('admin.search.bydate');
        Route::post('/admin/search/bymonth', 'AdminSearchByMonth')->name('admin.search.bymonth');
        Route::post('/admin/search/byyear', 'AdminSearchByYear')->name('admin.search.byyear');
    });
});

Route::middleware(['client', 'status'])->group(function () {
    Route::controller(RestaurantController::class)->group(function () {
        Route::get('/add/menu', 'AddMenu')->name('add.menu');
        Route::get('/all/menu', 'AllMenu')->name('all.menu');
        Route::get('/delete/menu/{id}', 'DeleteMenu')->name('delete.menu');
        Route::get('/edit/menu/{id}', 'EditMenu')->name('edit.menu');
        Route::post('/store/menu', 'StoreMenu')->name('menu.store');
        Route::post('/update/menu', 'UpdateMenu')->name('menu.update');
    });

    Route::controller(RestaurantController::class)->group(function () {
        Route::get('/add/product', 'AddProduct')->name('add.product');
        Route::get('/all/product', 'AllProduct')->name('all.product');
        Route::get('/delete/product/{id}', 'DeleteProduct')->name('delete.product');
        Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
        Route::post('/store/product', 'StoreProduct')->name('product.store');
        Route::post('/update/product', 'UpdateProduct')->name('product.update');
    });

    Route::controller(RestaurantController::class)->group(function () {
        Route::get('/add/gallery', 'AddGallery')->name('add.gallery');
        Route::get('/all/gallery', 'AllGallery')->name('all.gallery');
        Route::get('/delete/gallery/{id}', 'DeleteGallery')->name('delete.gallery');
        Route::get('/edit/gallery/{id}', 'EditGallery')->name('edit.gallery');
        Route::post('/store/gallery', 'StoreGallery')->name('gallery.store');
        Route::post('/update/gallery', 'UpdateGallery')->name('gallery.update');
    });

    Route::controller(CouponController::class)->group(function () {
        Route::get('/add/coupon', 'AddCoupon')->name('add.coupon');
        Route::get('/all/coupon', 'AllCoupon')->name('all.coupon');
        Route::get('/delete/coupon/{id}', 'DeleteCoupon')->name('delete.coupon');
        Route::get('/edit/coupon/{id}', 'EditCoupon')->name('edit.coupon');
        Route::post('/store/coupon', 'StoreCoupon')->name('coupon.store');
        Route::post('/update/coupon', 'UpdateCoupon')->name('coupon.update');
    });
    
    Route::controller(ManageOrdersController::class)->group(function () {
        Route::get('/all/client/orders', 'AllClientOrders')->name('all.client.orders');
        Route::get('/client/order/details}/{id}', 'ClientOrderDetails')->name('client.order.details');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/client/all/reports', 'ClientAllReports')->name('client.all.reports');
        Route::post('/client/search/bydate', 'ClientSearchByDate')->name('client.search.bydate');
        // Route::post('/admin/search/bymonth', 'AdminSearchByMonth')->name('admin.search.bymonth');
        // Route::post('/admin/search/byyear', 'AdminSearchByYear')->name('admin.search.byyear');
    });
});

//routes available for all users
Route::controller(RestaurantController::class)->group(function () {
    Route::get('/changeStatus', 'ChangeStatus');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/restaurant/details/{id}', 'RestaurantDetails')->name('restaurant.details');
    Route::post('/add-wish-list/{client_id}', 'AddWishlist');
});

Route::controller(CartController::class)->group(function () {
    Route::get('/add_to_cart/{id}', 'AddToCart')->name('add_to_cart');
    Route::post('/cart/update_quantity', 'UpdateCartQuantity')->name('cart.updateQuantity');
    Route::post('/cart/remove', 'RemoveFromCart')->name('cart.remove');
    Route::post('/apply-coupon', 'ApplyCoupon');
    Route::get('/remove-coupon', 'RemoveCoupon');
    Route::get('/checkout', 'ShopCheckout')->name('checkout');
});

Route::controller(OrderController::class)->group(function () {
    Route::post('/cash_order', 'CashOrder')->name('cash.order');
});