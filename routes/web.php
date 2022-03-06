<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Customer\ProductController as ProductController;
use App\Http\Controllers\Customer\CartController as CartController;
use App\Http\Controllers\Admin\UserContoller as UserDashboardContoller;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware'=>['global_data_share']] , function(){


Route::get('/', [Controller::class, 'index'])->name('index');

// Admin
Route::group(['middleware'=>['is_admin']] , function(){
        Route::get('/dashboard',[Controller::class, 'adminDashboard'])->name('dashboard')->middleware('auth');
        Route::get('/inventory',[AdminInventoryController::class, 'index'])->name('inventory.index');
        Route::post('/store/product',[AdminInventoryController::class, 'storeProduct'])->name('store.product');
        Route::get('/edit/product/form/{product_id}',[AdminInventoryController::class, 'editProductForm'])->name('edit.product.form');
        Route::post('/update/product/{product_id}',[AdminInventoryController::class, 'updateProduct'])->name('update.product');
        Route::get('/users',[UserDashboardContoller::class, 'index'])->name('show.users');
        Route::get('/view/user/{user_id}',[UserDashboardContoller::class, 'viewUser'])->name('view.user');
        Route::post('/update/user/{user_id}',[UserDashboardContoller::class, 'update'])->name('update.user');
        Route::post('/store/discount',[AdminInventoryController::class, 'storeNewDiscount'])->name('store.discount');
        Route::get('/orders',[App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders');
        Route::get('/edit/order',[App\Http\Controllers\Admin\OrderController::class, 'editOrder'])->name('edit.order');
        Route::get('/settings' , [App\Http\Controllers\Admin\SettingController::class , 'index'])->name('settings');
        Route::post('/update/settings' , [App\Http\Controllers\Admin\SettingController::class , 'update'])->name('update.settings');
});
/*
Route::get('/login-form',function(){
    return view('auth.login_form');
});
*/
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// customer
Route::get('/product/{product_id}', [ProductController::class, 'viewProduct'])->name('view.product');
Route::post('/add/product/toCart/{product_id}', [ProductController::class, 'addProductToCart'])->name('add.product.to.cart');
Route::post('/update/product/inCart/{product_id}', [ProductController::class, 'updateProductCart'])->name('update.product.in.cart');
Route::get('/view/my-cart', [CartController::class, 'viewCart'])->name('view.cart');
Route::get('/view/guest-cart', [CartController::class, 'viewGuestCart'])->name('view.guest.cart');
Route::post('/delete/cart/item/{cart_item}', [CartController::class, 'deleteCartItem'])->name('delete.cart.item');
Route::post('/delete/cart/content/{cart_id?}', [CartController::class, 'deleteCartContent'])->name('delete.cart.content');

Route::get('/checkout',[OrderController::class, 'checkout'])->name('checkout');
Route::post('/submit/order',[App\Http\Controllers\Customer\OrderController::class, 'submit'])->name('submit.order');
Route::get('/my-orders',[App\Http\Controllers\Customer\OrderController::class, 'showMyOrders'])->name('my.orders');
Route::get('/order/details/{order_id}',[App\Http\Controllers\Customer\OrderController::class, 'details'])->name('order.details');


Route::get('/my-profile',[ProfileController::class, 'myProfile'])->name('my.profile');
Route::post('/submit/profile',[ProfileController::class, 'submitProfile'])->name('submit.profile');


// display session
Route::get('/session', function(){
    return Session::get('cart');
});



// guest
Route::get('/sign-up', [Controller::class, 'signUpForm'])->name('sign.up');


});