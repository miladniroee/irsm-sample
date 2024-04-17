<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\Shop\BrandController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CategoryController;
use App\Http\Controllers\Shop\CouponController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Shop\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('/auth')->group(function () {

    Route::controller(\App\Http\Controllers\Auth\LoginController::class)->group(function () {
        Route::post('/otp', 'otpRequest');
        Route::post('/otp/verify', 'otpVerify')->middleware('auth:sanctum');
        Route::post('/login', 'loginWithPassword');
    });

    Route::controller(\App\Http\Controllers\Auth\PasswordController::class)->group(function () {
        Route::post('/password/create', 'createPassword')->middleware('auth:sanctum');
        Route::post('/password/update', 'updatePassword')->middleware('auth:sanctum');
        Route::post('/password/forget', 'forgetPassword');
        Route::post('/password/reset', 'resetPassword');
    });
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('/notifications')
        ->controller(\App\Http\Controllers\General\NotificationController::class)
        ->group(function () {
            Route::get('/', 'getNotifications');
            Route::get('/summery', 'index');
            Route::post('/mark-as-read', 'markAsRead');
            Route::post('/mark-all-as-read', 'markAllAsRead');
            Route::delete('/delete', 'delete');
        });

    Route::get('/user/info', [UserController::class, 'userInfo']);
    Route::get('/user/addresses', [UserController::class, 'userAddresses']);
    Route::post('/user/addresses/store', [UserController::class, 'storeAddress']);

    Route::get('/cart', [CartController::class, 'cart']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/update', [CartController::class, 'update']);

    Route::get('/wishlist', [WishlistController::class, 'wishlist']);
    Route::post('/wishlist/add', [WishlistController::class, 'add']);
    Route::post('/wishlist/remove', [WishlistController::class, 'remove']);

    Route::post('/checkout', [\App\Http\Controllers\Shop\Orders\OrderController::class, 'checkout']);

});


Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/category/{slug}', [BlogController::class, 'category']);
Route::get('/blog/search', [BlogController::class, 'search']);

Route::options('/post/sidebar/{slug}', [PostController::class, 'sidebar']);
Route::get('/post/{slug}', [PostController::class, 'index'])->name('blog.posts.index');


Route::get('/shop', [ShopController::class, 'index']);
Route::get('/shop/category/{slug}', [CategoryController::class, 'category'])->name('shop.category');
Route::get('/shop/categories', [CategoryController::class, 'all'])->name('shop.category');
Route::get('/shop/brand/{slug}', [BrandController::class, 'brand'])->name('shop.brand');
Route::get('/shop/brands', [BrandController::class, 'all'])->name('shop.brand');
Route::get('/shop/rt-search', [ShopController::class, 'realTimeSearch']);
Route::get('/shop/search', [ShopController::class, 'search']);
Route::get('/shop/filter', [ShopController::class, 'filter']);
Route::options('/shop/filter', [ShopController::class, 'filterOptions']);

Route::get('/product/{slug}/related', [ProductController::class, 'related'])->name('product.related');
Route::get('/product/{slug}/comments', [ProductController::class, 'comments'])->name('product.comments');
Route::post('/product/{slug}/comment/create', [ProductController::class, 'createComment'])->name('product.comment.create');
Route::get('/product/{slug}', [ProductController::class, 'index'])->name('product.index');

Route::post('/coupon',[CouponController::class, 'check']);

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'آدرس مورد نظر یافت نشد.',
        'status' => 404,
        'data' => null
    ], 404);
});
