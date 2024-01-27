<?php

use App\Http\Controllers\Api\AgencyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CorpAdvertiserController;
use App\Http\Controllers\Api\InfAccountPropertyController;
use App\Http\Controllers\Api\InfluencerCategoryController;
use App\Http\Controllers\Api\InfluencerController;
use App\Http\Controllers\Api\NavbarController;
use App\Http\Controllers\Api\OrderDetailController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductPropertyController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::get('agencies', [AgencyController::class, 'index']);
Route::get('agencies/{agency}', [AgencyController::class, 'show']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}/{with?}', [CategoryController::class, 'show']);

Route::get('influencers', [InfluencerController::class, 'index']);
Route::get('influencers/{influencer}', [InfluencerController::class, 'show']);

Route::get('influencer_categories', [InfluencerCategoryController::class, 'index']);
Route::get('influencer_categories/{influencerCategory}', [InfluencerCategoryController::class, 'show']);

Route::get('navbar', [NavbarController::class, 'index']);

Route::get('platforms', [PlatformController::class, 'index']);
Route::get('platforms/{platform}', [PlatformController::class, 'show']);

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);

Route::get('product-properties', [ProductPropertyController::class, 'index']);
Route::get('product-properties/{productProperty}', [ProductPropertyController::class, 'show']);


//eger admin degil ise middlewareden id ile gecemez auth id ile gececektir
Route::group(
    ['middleware' => 'ifAdminContinueWithUserIdInTheRequest'],
    function () {

//put methodu calismadigi icin update methodu icin ayrı bir route olusturuldu.
        Route::get('users', [UserController::class, 'show']);
        Route::get('users/{userID}', [UserController::class, 'show']);
        Route::post('users/update', [UserController::class, 'update']);
        Route::delete('users', [UserController::class, 'destroy']);
    },
);

//TODO SADECE USER KENDI BASKETINI CRUD YAPABILMELI
//eger admin degil ise middlewareden id ile gecemez auth id ile gececektir
Route::group(
    ['middleware' => 'ifAdminContinueWithOrderItemIdInTheRequest'],
    function () {
        Route::get('all-basket', [OrderDetailController::class, 'index']);
        Route::get('all-basket/{order_id}', [OrderDetailController::class, 'show']);
    },
);

//eger admin degil ise middlewareden id ile gecemez auth id ile gececektir
Route::group(
    ['middleware' => ['ifAdminContinueWithOrderItemIdInTheRequest', 'isOrderDetailActiveForOrderItem']],
    function () {
        //index methodu current basketi verecek show methodunu order detailsden alacagiz
        Route::get('basket', [OrderItemController::class, 'index']);
        Route::post('basket', [OrderItemController::class, 'store']);
        Route::delete('basket/{orderItemId}', [OrderItemController::class, 'destroy']);
        Route::put('basket/{orderItemId}', [OrderItemController::class, 'update']);
        Route::get('basket-unload', [OrderItemController::class, 'unloadBasket']);
    },
);









