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

//Route::group([
//    'middleware' => 'api',
//    'prefix' => 'auth'
//], function () {
//    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
//    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
//    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
//    Route::post('me', [\App\Http\Controllers\AuthController::class, 'me']);
//});

Route::group([
    'middleware' => 'auth.api',
    'prefix' => 'app'
], function () {
    Route::resource('/expenses', \App\Http\Controllers\ExpenseController::class);
    Route::resource('/expenses-categories', \App\Http\Controllers\ExpensesCategoryController::class);
    Route::resource('/incomes', \App\Http\Controllers\IncomeController::class);
    Route::resource('/notifications', \App\Http\Controllers\NotificationController::class);
    Route::resource('/recurrent-expenses', \App\Http\Controllers\RecurrentExpenseController::class);
    Route::resource('/recurrent-incomes', \App\Http\Controllers\RecurrentIncomeController::class);
});
