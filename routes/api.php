<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\SplitBillController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MerchantController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::post('register', [AuthController::class, 'register'])->middleware('throttle:10,1');
Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');

// Protected Routes
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    // Profile
    Route::get('user', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);

    // Admin Routes
    Route::middleware('can:admin-only')->group(function () {
        Route::post('admin/topup', [AdminController::class, 'topup']);
        Route::get('admin/users', [AdminController::class, 'listUsers']);
    });

    // Merchant Routes
    Route::middleware('can:merchant-only')->group(function () {
        Route::post('merchant/scan-pay', [MerchantController::class, 'scanAndPay']);
        Route::get('merchant/products', [MerchantController::class, 'listProducts']);
        Route::post('merchant/products', [MerchantController::class, 'addProduct']);
        Route::delete('merchant/products/{id}', [MerchantController::class, 'deleteProduct']);
        Route::get('merchant/sales', [MerchantController::class, 'salesHistory']);
    });

    // Transfer
    Route::post('transfer', [TransferController::class, 'transfer']);

    // Split Bill
    Route::post('split-bill', [SplitBillController::class, 'store']);
    Route::post('split-bill/pay/{memberId}', [SplitBillController::class, 'pay']);
    Route::get('my-split-bills', [SplitBillController::class, 'myCreatedBills']);
    Route::get('incoming-split-bills', [SplitBillController::class, 'myIncomingBills']);

    // User Transactions (History)
    Route::get('my-transactions', [TransactionController::class, 'userHistory']);
});

// Admin/Public Routes (Adjust as needed)
Route::get('allusers', [UserController::class, 'index']);
Route::get('getusers/{id}', [UserController::class, 'show']);
Route::post('postusers', [UserController::class, 'store']);
Route::put('updateusers/{id}', [UserController::class, 'update']);
Route::delete('deletusers/{id}', [UserController::class, 'destroy']);

Route::get('alltopup', [TopupController::class, 'index']);
Route::get('gettopup/{id}', [TopupController::class, 'show']);
Route::post('posttopup', [TopupController::class, 'store']);
Route::post('updatetopup/{id}', [TopupController::class, 'update']);
Route::delete('delettopup/{id}', [TopupController::class, 'destroy']);

Route::get('alltransaction', [TransactionController::class, 'index']);
Route::get('gettransaction/{id}', [TransactionController::class, 'show']);
Route::post('posttransaction', [TransactionController::class, 'store']);
Route::post('updatetransaction/{id}', [TransactionController::class, 'update']);
Route::delete('delettransaction/{id}', [TransactionController::class, 'destroy']);

Route::get('leaderboard', [LeaderboardController::class, 'showjuragan']);
