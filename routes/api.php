<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('send-verify-email', [UserController::class, 'reSendVerifyEmail']);
Route::post('verify-email', [UserController::class, 'verifyEmail']);

Route::group([
                 'middleware' => ['checkBannedOrDeletedNonAuth', 'isEmailVerifiedNonAuth'],
                 'namespace'  => 'App\Http\Controllers\Api',

             ], function () {

    Route::post('login', [AuthController::class, 'login']);

    Route::post('recover', [AuthController::class, 'recover']);

    Route::post('forgot_password', [UserController::class, 'forgotPassword']);

    Route::post('reset_password', [UserController::class, 'resetPassword']);

});

Route::group([
                 'middleware' => ['auth:api', 'checkBannedOrDeletedWithAuth', 'isEmailVerifiedWithAuth'],
                 'namespace'  => 'App\Http\Controllers\Api',
             ], function () {

    require 'api/user.php';
    require 'api/influencer.php';

    Route::get('send-sms', [UserController::class, 'smsSendCustomMessage']);
    Route::get('send-verify-sms', [UserController::class, 'smsSendVerificationCode']);
    Route::post('verify-phone', [UserController::class, 'verifyPhone']);

});


//bu routeler icin farkli bir middleware kullanilacak
Route::group(['middleware' => 'web'], function () {
    Route::get('social/{platformTypes}', [UserController::class, 'redirectToPlatformRegister']);
    Route::get('google/welcome', [UserController::class, 'handleGoogleCallback']);
});
