<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\UserController;

Route::middleware(['guest'])->group(function () {
  Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
  });
});

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);
Route::get('products/color/{color}', [ProductController::class, 'filterProductsByColor']);
Route::get('products/size/{size}', [ProductController::class, 'filterProductsBySize']);
Route::get('products/find/{term}', [ProductController::class, 'filterProductsByTerm']);
Route::get('products/{product}/reviews', [ReviewController::class, 'index']);
Route::get('products/{product}/reviews/{review}', [ReviewController::class, 'show']);

Route::middleware(['auth:api'])->group(function () {
  Route::post('refresh', [AuthController::class, 'refresh']);
  Route::post('me', [AuthController::class, 'me']);
  Route::post('logout', [AuthController::class, 'logout']);

  Route::post('updateUserProfile', [UserController::class, 'updateUserProfile']);

  Route::post('applyCoupon', [CouponController::class, 'applyCoupon']);

  Route::post('orders', [OrderController::class, 'store']);
  Route::post('payOrderByStripe', [OrderController::class, 'payOrderByStripe']);

  Route::apiResource('products.reviews', ReviewController::class)->except(['index', 'show']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
  Route::group(['prefix' => 'admin'], function () {
    Route::apiResource('colors', ColorController::class);
    Route::apiResource('sizes', SizeController::class);
    Route::apiResource('coupons', AdminCouponController::class);
    Route::apiResource('products', AdminProductController::class);

    Route::get('orderInfo', [AdminOrderController::class, 'orderInfo']);
    Route::get('orders', [AdminOrderController::class, 'index']);
    Route::put('orders/{order}', [AdminOrderController::class, 'updateDeliveredAtDate']);
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy']);

    Route::get('reviews', [AdminReviewController::class, 'index']);
    Route::put('reviews/{review}', [AdminReviewController::class, 'toggleApprovedStatus']);
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy']);

    Route::get('users', [AdminUserController::class, 'index']);
    Route::delete('users/{user}', [AdminUserController::class, 'destroy']);
  });
});
