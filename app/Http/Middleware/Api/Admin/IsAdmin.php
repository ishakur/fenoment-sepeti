<?php

namespace App\Http\Middleware\Api\Admin;

use App\Enum\UserTypes;
use App\Http\Controllers\Api\ApiController;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request                                       $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->getUserType() != UserTypes::Admin)
            throw new AuthorizationException(__('auth.unauthorized'));

        return $next($request);
    }
}
