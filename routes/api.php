<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SaldoApiController;
use App\Http\Controllers\API\CartApiController;
use App\Http\Controllers\API\DataApiController;
use App\Http\Controllers\API\UserApiController;
use App\Http\Controllers\API\OrderApiController;
use App\Http\Controllers\API\MarketApiController;
use App\Http\Controllers\API\ProductApiController;
use App\Http\Controllers\API\CategoryApiController;
use App\Http\Controllers\API\TransactionApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// USER
Route::post('register', [UserApiController::class, 'register']);
Route::post('login', [UserApiController::class, 'login']);
Route::get('users', [UserApiController::class, 'users']);
Route::post('update/{id}', [UserApiController::class, 'update']);
// Route::get('user/{id}', [UserController::class, 'user']);
// Route::delete('delete/{id}', [UserController::class, 'delete']);

// MARKET
// Route::get('markets', [MarketApiController::class, 'markets']);
// Route::get('market/{id}', [MarketApiController::class, 'fetch']);
// Route::post('createMarket', [MarketApiController::class, 'createMarket']);
// // Route::post('uploadPhotoMarket/{id}', [MarketApiController::class, 'uploadPhotoMarket']);
// Route::post('updateMarket/{id}', [MarketApiController::class, 'updateMarket']);
// Route::get('limitsMarket', [MarketApiController::class, 'limitsMarket']);

// PRODUCT
Route::get('tickets', [ProductApiController::class, 'tickets']);
Route::get('limits', [ProductApiController::class, 'limits']);
Route::get('ticket/{id}', [ProductApiController::class, 'ticket']);
Route::get('search/{name}', [ProductApiController::class, 'search']);

// CATEGORY
Route::get('categories', [CategoryApiController::class, 'categories']);
Route::get('category/{id}', [CategoryApiController::class, 'category']);

// DATA
Route::get('districts', [DataApiController::class, 'districtsBaktiya']);

// ORDER
Route::get('orderMarket/{id}', [OrderApiController::class, 'orderMarket']);
Route::get('orderUser/{id}', [OrderApiController::class, 'orderUser']);
Route::get('allOrder', [OrderApiController::class, 'allOrder']);
Route::put('statusOrder/{id}', [OrderApiController::class, 'statusOrder']);
Route::post('verify-payment', [OrderApiController::class, 'verifyPayment']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserApiController::class, 'fetch']);
    Route::post('logout', [UserApiController::class, 'logout']);

    // CART
    Route::post('addCart', [CartApiController::class, 'addCart']);
    Route::get('myCart', [CartApiController::class, 'myCart']);
    Route::delete('deleteCart/{id}', [CartApiController::class, 'deleteCart']);
    Route::delete('deleteAllCart', [CartApiController::class, 'deleteAllCart']);
    Route::put('updateCart/{id}', [CartApiController::class, 'updateCart']);
    Route::get('cart/{id}', [CartApiController::class, 'cart']);

    // ORDER
    Route::post('checkout', [OrderApiController::class, 'checkout']);
    Route::post('topup', [SaldoApiController::class, 'topup']);
    Route::get('/get-topup-status', [SaldoApiController::class, 'getTopupStatusByUser']);
});
