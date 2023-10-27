<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use App\Mail\OrderConfirmationEmail;
use App\Models\User;
use App\Notifications\InvoicePaidNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("v1")->group(function () {
    Route::get('/status', function (Request $request){
        return response()->json([
            "status"    =>  "active",
            "api_version"   =>  "2023.10.1"
        ]);
    });
    Route::post("users", [UserController::class, "store"]);
    Route::apiResource("products", ProductController::class);
    Route::apiResource("orders", OrderController::class);
    Route::apiResource("carts", CartController::class);

    Route::prefix("auth")->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('login', 'login');
            Route::post('register', 'register');
            Route::post('logout', 'logout');
            Route::post('refresh', 'refresh');
        });
    });
});