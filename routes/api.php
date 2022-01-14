<?php

use App\Http\Controllers\Api\AdminPageController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SuperadminPageController;
use App\Http\Controllers\Api\User\CartController;
use App\Http\Controllers\Api\User\CheckoutController;
use App\Http\Controllers\Api\User\DecorationController;
use App\Http\Controllers\Api\User\DecorationitemController;
use App\Http\Controllers\Api\User\DecorationpacketController;
use App\Http\Controllers\Api\User\GalleryController;
use App\Http\Controllers\Api\User\HomepageController;
use App\Http\Controllers\Api\User\InvoiceController;
use App\Http\Controllers\Api\User\OrderController;
use App\Http\Controllers\Api\User\ParternController;
use App\Http\Controllers\Api\User\ReceiptController;
use App\Http\Controllers\Api\UserPageController;
use App\Http\Resources\Page\GalleryResource;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('home', [HomepageController::class, 'index']);
Route::post('auth', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('roleApi:superadmin,admin,user');
Route::post('register', [AuthController::class, 'register']);
Route::get('decoration/packets', [DecorationpacketController::class, 'index']);
Route::get('decoration/packet/{id}', [DecorationpacketController::class, 'show']);
Route::get('decoration/items', [DecorationitemController::class, 'index']);
Route::get('decoration/item/{id}', [DecorationitemController::class, 'show']);
Route::get('partern/items', [ParternController::class, 'index']);
Route::get('partern/item/{id}', [ParternController::class, 'show']);
Route::get('galleries', [GalleryController::class, 'index']);
Route::get('gallery/{slug}', [GalleryController::class, 'show']);

Route::group(['prefix' => 'self', 'middleware' => ['roleApi:user']], function () {
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/add/{id}', [CartController::class, 'store']);
    Route::post('cart/addQty/{id}', [CartController::class, 'increaseQty']);
    Route::post('cart/minQty/{id}', [CartController::class, 'decreaseQty']);  
    Route::post('cart/remove/{id}', [CartController::class, 'destroy']);
    Route::get('checkout', [CheckoutController::class, 'index']);
    Route::post('checkout/add', [CheckoutController::class, 'store']);
    Route::post('checkout/update', [CheckoutController::class, 'update']);
    Route::get('order', [OrderController::class, 'index']);
    Route::post('order/add', [OrderController::class, 'store']);
    Route::post('order/upload', [OrderController::class, 'uploadBukti']);
    Route::post('invoice', [InvoiceController::class, 'index']);
    Route::post('receipt', [ReceiptController::class, 'index']);    
});

Route::group(['prefix' => 'admin', 'middleware' => 'roleApi:superadmin,admin'], function () {
    
});
