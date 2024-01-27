<?php

namespace App\Http\Middleware\Api\Influencer;

use App\Enum\UserTypes;
use App\Http\Controllers\Api\ApiController;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class IsInfluencer
{
    /**
     * Handle an incoming request.
     *
     * @param Request                                       $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->getUserType() != UserTypes::Influencer)
            throw new AuthorizationException();

        return $next($request);
    }
}
