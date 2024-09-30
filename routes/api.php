<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\PreferenceController;
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


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [UserController::class, 'logout']);

    Route::prefix('articles')->controller(ArticleController::class)->middleware('throttle:api')->group(function () {
        Route::get('', 'index');
        Route::get('search', 'search');
        Route::get('{article}', 'show');
    });


    Route::controller(PreferenceController::class)->middleware('throttle:api')->group(function () {
        Route::post('/preferences', 'updateOrCreate');
        Route::get('/preferences', 'userPreference');
        Route::get('/feed', 'personalizedFeed');
    });


});
