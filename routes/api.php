<?php

use App\Http\Controllers\AmbassadorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('admin')->group( function () {
    Route::post('register', [ AuthController::class, 'register']);
    Route::post('login', [ AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'scope.admin',])->group( function () {
        
        // user
        Route::get('/profile', [ AuthController::class, 'user']);
        Route::put('/info', [ AuthController::class, 'updateInfo']);
        Route::put('/password', [ AuthController::class, 'updatePassword']);
        Route::delete('users/{id}/delete', [ AuthController::class, 'destroy']);
        Route::post('logout', [ AuthController::class, 'logout']);

        // ambassador
        Route::get('ambassadors', [AmbassadorController::class, 'index']);
        Route::get('users/{id}/links', [LinkController::class, 'index']);
        Route::get('orders', [OrderController::class, 'index']);

        // product
        Route::apiResource('products', ProductController::class);
    });
  
});

// ambassador routes
Route::prefix('ambassador')->group( function () {
    Route::post('register', [ AuthController::class, 'register']);
    Route::post('login', [ AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'scope.ambassador',])->group( function () {
        
        // user info
        Route::get('/profile', [ AuthController::class, 'user']);
        Route::put('/info', [ AuthController::class, 'updateInfo']);
        Route::put('/password', [ AuthController::class, 'updatePassword']);
        Route::delete('/{id}/delete', [ AuthController::class, 'destroy']);
        Route::post('logout', [ AuthController::class, 'logout']);

        // ambassador
        Route::get('/{id}/links', [LinkController::class, 'index']);
    });

    // guest
    Route::get('products/frontend', [ProductController::class,  'frontEnd']);
    Route::get('products/backend', [ProductController::class,  'backEnd']);
  
});
