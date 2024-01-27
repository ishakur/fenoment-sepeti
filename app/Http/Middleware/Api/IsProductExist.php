<?php

namespace App\Http\Middleware\Api;

use App\Exceptions\AlreadyExist;
use App\Exceptions\AlreadySameData;
use App\Exceptions\NotFound;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Mockery\Matcher\Not;

class IsProductExist
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request                                                                          $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->method() == 'POST') {

            $product = Product::where('influencer_id', $request->influencer_id)
                              ->where('product_property_id', $request->product_property_id);
            if ($product->exist())
                throw new AlreadyExist(ApiController::getTextFromKeywordsLanguageFile('platform'));

            return $next($request);

        } else if ($request->method() == 'PUT') {

            $product = Product::where('influencer_id', $request->influencer_id)
                              ->where('product_property_id', $request->product_property_id)
                              ->where('price_for_per_minute', $request->price_for_per_minute);
            if ($product->exists())
                throw new AlreadySameData(ApiController::getTextFromKeywordsLanguageFile('productPrice'));

            return $next($request);

        } else if ($request->method() == 'DELETE') {

            if (!$request->route('product'))
                throw new NotFound(ApiController::getTextFromKeywordsLanguageFile('platform'));

            return $next($request);
        }
    }
}
