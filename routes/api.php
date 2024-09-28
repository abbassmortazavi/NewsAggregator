<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login')->middleware('throttle:api');
    Route::post('/password/reset-password', 'resetPassword');
    Route::post('/password/send-code', 'sendCode');
    Route::post('/verifyCode', 'verifyCode');
});


Route::group(['api','middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [UserController::class, 'logout']);


});
