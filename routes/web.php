<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;

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

Route::get('/', function () {
    return view('layouts');
});

Route::get('/userlist', function () {
    return view('UserListing');
});

Route::get('/forget_password', function () {
    return view('auth.forget_password');
});

Route::get('/products', function () {
    return view('Products.productList');
});

Route::controller(LoginRegisterController::class)->group(function() {

    Route::group(['middleware' => 'guest'], function () {

        Route::group(['middleware' => RedirectIfAuthenticated::class], function () {
            Route::get('/register', 'register')->name('register');
            Route::get('/register', [RoleController::class, 'index'])->name('register');
        });
        Route::post('/store', 'store')->name('store');
        Route::get('/login', 'login')->name('login');
        Route::post('/authenticate', 'authenticate')->name('authenticate');

        Route::get('/login/github','redirectToGithub')->name('login.github');
        Route::get('/login/github/callback', 'handleGithubCallback');

        Route::get('/login/google','redirectToGoogle')->name('login.google');
        Route::get('/login/google/callback', 'handleGoogleCallback');
    });

    Route::get('/dashboard', 'dashboard')->name('dashboard');

    Route::middleware(['auth', 'checkRole:admin'])->group(function () {
        Route::get('/admin/dashboard', 'adminDashboard')->name('admin.dashboard');
    });
    Route::middleware(['auth', 'checkRole:seller'])->group(function () {
        Route::get('/seller/dashboard', 'sellerDashboard')->name('seller.dashboard');
    });

    Route::post('/logout', 'logout')->name('logout');
});


Route::controller(ResetPasswordController::class)->group(function() {
    Route::post('/sendEmailOTP', 'sendOTPEmail')->name('sendEmailOTP');
    Route::get('/verifyOTP', 'showVerifyOTP')->name('showVerifyOTP');
    Route::get('/resetPassword', 'showResetPassword')->name('showResetPassword');
    Route::post('/setNewPassword', 'resetPassword')->name('setNewPassword');
    Route::post('/verifyEmailOTP', 'verifyEmailOTP')->name('verifyEmailOTP');
    Route::prefix('profile')->middleware(['web', 'auth'])->group(function () {
    Route::get('/change-password', function (){
        return view('profile.changePassword');
    })->name('profile.change.password');
        Route::post('/change-password', 'changePassword')->name('changes.password');
    });

    Route::post('/forget_password', 'sendOTPEmail')->name('sendEmailOTP');
});


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    // Optionally return a message
    return "Cache cleared!";
});

Route::controller(UserController::class)->group(function() {
    Route::prefix('admin')->middleware(['web', 'auth', 'checkRole:admin'])->group(function () {
        Route::get('/user-listing', 'index')->name('users.indexs');
        Route::post('/user-listing', 'index')->name('users.index');
        Route::post('/user-roles', [RoleController::class, 'getUserRoleList'])->name('user.roles');

        Route::get('user/edit-{id}', 'editUserData');
        Route::post('/user/update-{user}', 'updateUserData');
        Route::get('/user/delete-{user}', 'deleteUserData');
        Route::post('/user/addNew', 'addNewUser');
        Route::get('/getSellerList', 'getSellerList');
    });
});


Route::controller(ProductController::class)->group(function() {
    Route::middleware(['web', 'auth', 'checkRole:admin'])->group(function () {
        Route::get('/admin/product-listing', 'index')->name('products.index');
        Route::post('/admin/product-listing', 'index')->name('product.index');
        Route::get('/admin/showProductForm', 'showAddProductForm')->name('product.showForm');
        Route::get('/admin/product/update-{productDetails}', 'showUpdateProductForm')/* ->name('product.showUpdateForm') */;
        Route::post('/admin/addProduct', 'addNewProduct')->name('product.addProduct');
        Route::post('/admin/product/updateProduct-{productDetails}', 'updateProduct')->name('product.updateProduct');
        Route::get('/admin/products/delete-{product}', 'deleteProductData');
    });

    Route::middleware(['web', 'auth', 'checkRole:seller'])->group(function () {
        Route::get('/seller/product-listing', 'getProductBySeller')->name('seller_Products');
        Route::post('/seller/product-listing', 'getProductBySeller')->name('seller_Products');
        Route::get('/seller/showProductForm', 'showSellerAddProductForm')->name('seller_product.showForm');
        Route::get('/seller/product/update-{productDetails}', 'showUpdateSellerProductForm')/* ->name('seller_product.showUpdateForm') */;
    });

    Route::get('/product/{id}','getProductByID')->name('showProduct');
    Route::get('/products', 'getProductForHome')->name('productsList');
});


Route::controller(SubCategoryController::class)->group(function() {
    Route::middleware(['web', 'auth', 'checkRole:admin'])->group(function () {
        Route::post("/admin/getSubCategory",'getSubcategory');
        Route::post("/admin/getFilterSubCategory-{categoryId}",'getSubcategoryOfParentCategory');
    });
});


Route::controller(CategoryController::class)->group(function() {
    Route::middleware(['web', 'auth', 'checkRole:admin'])->group(function () {
        Route::get("/admin/getCategory",'getCategory');
    });
});

Route::controller(PayPalController::class)->group(function() {
    Route::middleware(['web', 'auth'])->group(function () {
        Route::get('create-transaction', 'createTransaction')->name('createTransaction');
        Route::post('process-transaction', 'processTransaction')->name('processTransaction');
        Route::get('success-transaction', 'successTransaction')->name('successTransaction');
        Route::get('cancel-transaction', 'cancelTransaction')->name('cancelTransaction');

    });
});

Route::controller(CartController::class)->group(function() {
    Route::middleware(['web', 'auth'])->group(function () {
        Route::get('cart', 'index')->name('cart.index');
        Route::post('cart/add', 'addToCart')->name('cart.add');
        Route::post('cart/update/{cartId}', 'updateQuantity')->name('cart.update');
        Route::delete('cart/remove/{cartId}', 'removeIte')->name('cart.remove');
    });

});

Route::controller(CheckoutController::class)->group(function() {
    Route::middleware(['web', 'auth'])->group(function () {
        Route::get('checkout', 'index')->name('checkout.index');
    });

});

Route::controller(ProfileController::class)->group(function() {
    Route::prefix('profile')->middleware(['web', 'auth'])->group(function () {
        Route::get('/', 'show')->name('profile.show');
        Route::get('setting', 'showProfileSetting')->name('profile.setting');
        Route::post('/save', 'saveProfileChange')->name('profile.save');
    });

});
Route::controller(OrderController::class)->group(function() {
    Route::prefix('profile')->middleware(['web', 'auth'])->group(function () {
        Route::get('/orders', 'index')->name('profile.order');
        Route::post('/order/{order}/refund', 'cancelOrder')->name('order.cancel');
    });

    Route::prefix('admin')->middleware(['web', 'auth', 'checkRole:admin'])->group(function () {
        Route::get('/order-listing', 'orderListing')->name('order.index');
        Route::get('/orders/{order}', 'show')->name('admin.orders.show');
        Route::get('/order/delete-{order}', 'deleteOrder');
        Route::post('/orders/{order}/update', 'update')->name('admin.orders.update');
    });
});
