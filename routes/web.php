<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Customer\ProductController as ProductController;
use App\Http\Controllers\Customer\CartController as CartController;
use App\Http\Controllers\Admin\UserContoller as UserDashboardContoller;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [Controller::class, 'index'])->name('index');

// Admin
Route::group(['middleware'=>['is_admin']] , function(){
        Route::get('/dashboard',[Controller::class, 'adminDashboard'])->name('dashboard')->middleware('auth');
        Route::get('/inventory',[AdminInventoryController::class, 'index'])->name('inventory.index');
        Route::post('/store/product',[AdminInventoryController::class, 'storeProduct'])->name('store.product');
        Route::get('/edit/product/form/{product_id}',[AdminInventoryController::class, 'editProductForm'])->name('edit.product.form');
        Route::post('/update/product/{product_id}',[AdminInventoryController::class, 'updateProduct'])->name('update.product');
        Route::get('/users',[UserDashboardContoller::class, 'show'])->name('show.users');
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
Route::get('/view/my-cart', [CartController::class, 'viewCart'])->name('view.cart');




// guest
Route::get('/sign-up', [Controller::class, 'signUpForm'])->name('sign.up');

