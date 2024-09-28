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

    Route::resource('articles', ArticleController::class);
    Route::resource('preferences', PreferenceController::class)->middleware('throttle:api');

    Route::controller(PreferenceController::class)->middleware('throttle:api')->group(function () {
        Route::post('/preferences', 'updateOrCreate');
        Route::get('/preferences', 'userPreference');
        Route::get('/feed', 'personalizedFeed');
    });


});
