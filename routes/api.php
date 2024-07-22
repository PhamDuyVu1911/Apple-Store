<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\SpecificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


// Auth
Route::group(['middleware' => 'api','prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('change-pass', [AuthController::class, 'changePassWord']);
    Route::get('profile', [AuthController::class, 'profile']);
});

// Categories
Route::group(['middleware' => 'api'], function () {
    Route::apiResource('categories', CategoryController::class);
});

// Products
Route::group(['middleware' => 'api'], function () {
    Route::apiResource('products', ProductController::class);
});

// Specifications
Route::group(['middleware' => 'api'], function () {
    Route::apiResource('specifications', SpecificationController::class);
});

// Images
Route::group(['middleware' => 'api'], function () {
    Route::apiResource('images', ImageController::class);
});

// Orders
Route::group(['middleware' => 'api'], function () {
    Route::apiResource('orders', OrderController::class);
});

// Order detail
Route::group(['middleware' => 'api'], function () {
    Route::apiResource('orderDetails', OrderDetailController::class);
});


