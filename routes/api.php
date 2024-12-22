<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/register', RegisterController::class);
Route::post('auth/login', LoginController::class);

Route::apiResource('products', ProductController::class);

Route::middleware('auth:sanctum')->group(function() {

    Route::apiResource('cart', CartController::class);

});