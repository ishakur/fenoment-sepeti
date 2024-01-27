<?php

namespace App\Http\Middleware\Api;

use App\Exceptions\AlreadyExist;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IsPlatformExist
{
    /**
     * Handle an incoming request.
     *
     * @param Request                                       $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $platform = Platform::where('platform_name', $request->platform_name);
        if ($platform->exists())
            throw new AlreadyExist(ApiController::getTextFromKeywordsLanguageFile('platform'));
        return $next($request);
    }
}
