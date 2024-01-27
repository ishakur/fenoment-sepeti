<?php


use Illuminate\Http\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('docs');
});

Route::get('test', function () {
    return view('welcome');
});

Route::get('docs', function () {
    return storage_path('');
});
Route::get('assets/images/{fileName}', [\App\Http\Controllers\Api\UserController::class, 'getImage']);

//Route::get('google', [UserController::class, 'redirectToGoogle']);
//Route::get('google/callback', [UserController::class, 'handleGoogleCallback']);


//Route::get('user/verify/{verification_code}', [EmailController::class, 'verifyUser']);
//Route::get('resendVerifyEmail', [EmailController::class, 'resendVerifyEmail']);


//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
//Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');
Route::get('php-info', function () {
    phpinfo();
});

