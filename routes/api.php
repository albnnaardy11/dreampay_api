<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\TransactionController;

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

Route::get('allusers', [UserController::class, 'index']);
Route::get('datausers/{id}', [UserController::class, 'show']);
Route::post('postusers', [UserController::class, 'store']);
Route::put('updateusers/{id}', [UserController::class, 'update']);
Route::delete('deletusers/{id}', [UserController::class, 'destroy']);

Route::get('alltopup', [TopupController::class, 'index']);
Route::get('datatopup/{id}', [TopupController::class, 'show']);
Route::post('posttopup', [TopupController::class, 'store']);
Route::post('updatetopup/{id}', [TopupController::class, 'update']);
Route::delete('delettopup/{id}', [TopupController::class, 'destroy']);

Route::get('alltransaction', [TransactionController::class, 'index']);
Route::get('datatransaction/{id}', [TransactionController::class, 'show']);
Route::post('posttransaction', [TransactionController::class, 'store']);
Route::post('updatetransaction/{id}', [TransactionController::class, 'update']);
Route::delete('delettransaction/{id}', [TransactionController::class, 'destroy']);


