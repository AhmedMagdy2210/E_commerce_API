<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\Color_Size\SizesController;
use App\Http\Controllers\Color_color\ColorsController;
use App\Http\Controllers\API\Products\ProductsController;
use App\Http\Controllers\API\Admin\Categories\CategoriesController;
use App\Http\Controllers\CartController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::prefix('dashboard')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('/categories', CategoriesController::class);
    Route::apiResource('/products', ProductsController::class);
    Route::apiResource('/sizes', SizesController::class);
    Route::apiResource('/colors', ColorsController::class);
});

Route::prefix('profile')->middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::put('/cart/{id}', [CartController::class, 'update']);
    Route::get('/cart/clear', [CartController::class, 'clear']);
});

Route::prefix('public')->group(function () {
    Route::get('/products', [ProductsController::class, 'index']);
});
