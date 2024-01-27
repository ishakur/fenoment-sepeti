<?php

namespace App\Http\Middleware\Api\Auth;

use App\Enum\UserTypes;
use App\Exceptions\NotFound;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckBannedOrDeletedWithAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request                                        $request
     * @param \Closure(Request): (Response|RedirectResponse) $next
     */
    public function handle(Request $request, Closure $next)
    {

        $user = auth()->user();
        if ($user->userType == UserTypes::Banned || $user->userType == UserTypes::Deleted) {
            app(AuthController::class)->logout();
            throw new NotFound(ApiController::getTextFromKeywordsLanguageFile('user'));
        }

        return $next($request);
    }
}

