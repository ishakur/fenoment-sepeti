<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AgencyController;
use App\Http\Controllers\Api\CorpAdvertiserController;
use App\Http\Controllers\Api\InfAccountPropertyController;
use App\Http\Controllers\Api\InfluencerCategoryController;
use App\Http\Controllers\Api\OrderDetailController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductPropertyController;
use App\Http\Controllers\Api\UserController;

//Route::apiResources([
//                        'agencies'            => AgencyController::class,
//                        'corporate'           => CorpAdvertiserController::class,
//                        'products'            => ProductController::class,
//                        'platforms'           => PlatformController::class,
//                        'product-property'    => ProductPropertyController::class,
//                        'order-detail'        => OrderDetailController::class,
//                        'order-item'          => OrderItemController::class,
//                        'influencer-category' => InfluencerCategoryController::class,
//                        'influencer-account-property'    => InfAccountPropertyController::class,
//                        'product'             => ProductController::class,
//                    ],
//);
//
//Route::apiResource('users', UserController::class)->except(['update', 'destroy']);
//
////profilePhoto file yalnizca post methodunda calistigi icin update methodu icin ayrı bir route olusturuldu.
//Route::post('users/update', [UserController::class, 'update']);
//
////deletede ise destroy yerine delete methodu kullanildi
//Route::delete('users', [UserController::class, 'delete']);