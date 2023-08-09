<?php

use Illuminate\Http\Request;
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

/**
 * Auth Routes
 */
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\Auth\AuthController::class, 'refresh']);
    Route::post('me', [\App\Http\Controllers\Auth\AuthController::class, 'me']);
});

/**
 * Verification Routes
 */
Route::group([
    'middleware' => 'api',
    'prefix' => 'verification'
], function () {
    Route::get('/email/verify', [\App\Http\Controllers\Auth\VerificationController::class, 'notice'])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\Auth\VerificationController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify')
        ->missing(function () {
            return response()->json([
                'message' => 'Resource not found'
            ], 404);
        });

    Route::post('/email/resend', [\App\Http\Controllers\Auth\VerificationController::class, 'resend'])
        ->middleware('auth.api')
        ->name('verification.send');
});

/**
 * App Routes
 */
Route::group([
    'middleware' => ['auth.api', 'verified'],
    'prefix' => 'app'
], function () {
    Route::resource('/expenses', \App\Http\Controllers\ExpenseController::class);
    Route::resource('/expenses-categories', \App\Http\Controllers\ExpensesCategoryController::class);
    Route::resource('/incomes', \App\Http\Controllers\IncomeController::class);
    Route::resource('/notifications', \App\Http\Controllers\NotificationController::class);
    Route::resource('/recurrent-expenses', \App\Http\Controllers\RecurrentExpenseController::class);
    Route::resource('/recurrent-incomes', \App\Http\Controllers\RecurrentIncomeController::class);
});
