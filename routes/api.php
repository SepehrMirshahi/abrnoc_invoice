<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
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
Route::post('/login', [UserController::class, 'login']);
Route::post('/signup', [UserController::class, 'signup']);

Route::middleware('auth')->group(function () {
    Route::get('logout', [UserController::class, 'logout']);
    Route::post('/addcredit', [UserController::class, 'addCredit']);
    Route::post('/subscribe', [SubscriptionController::class, 'store']);
    Route::post('/unsubscribe/{subscription}', [SubscriptionController::class, 'unsubscribe']);
    Route::post('/report', [ReportController::class, 'invoiceReport']);
});
