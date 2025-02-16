<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Products\ProductsController;
use App\Http\Controllers\API\Admin\Categories\CategoriesController;
use App\Http\Controllers\Color_Size\ColorsController;
use App\Http\Controllers\Color_Size\SizesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::apiResource('/categories', CategoriesController::class);
Route::apiResource('/products', ProductsController::class);
Route::apiResource('/sizes', SizesController::class);
