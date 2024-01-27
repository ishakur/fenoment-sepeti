<?php

namespace App\Http\Middleware\Api;

use App\Exceptions\AlreadyExist;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductPropertyResource;
use App\Models\ProductProperties;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IsProductPropertyExist
{
    /**
     * Handle an incoming request.
     *
     * @param Request                                       $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $product = ProductProperties::where('property_name', $request->property_name)
                                    ->where('platform_id', $request->platform_id);
        if ($product->exists())
            throw new AlreadyExist(ApiController::getTextFromKeywordsLanguageFile('platform'));

        return $next($request);
    }
}
