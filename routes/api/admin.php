<?php

Route::group([
                 'middleware' => ['auth:api', 'isAdmin'],
                 'namespace'  => 'App\Http\Controllers\Api',
             ], function ($router) {

    Route::apiResources(array(
                            'agency'              => AgencyController::class,
                            'corporate'           => CorpAdvertiserController::class,
                            'categories'          => CategoryController::class,
//                            'products'            => ProductController::class,
                            'platforms'           => PlatformController::class,
                            'influencer-category' => InfluencerCategoryController::class,
                            'product-property'    => ProductPropertyController::class,
                        ));
});
