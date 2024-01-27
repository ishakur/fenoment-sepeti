<?php

namespace App\Http\Middleware\Api\User;

use App\Enum\UserTypes;
use App\Exceptions\PermissionDenied;
use App\Http\Controllers\Api\ApiController;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param Request                                       $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     */
    public function handle(Request $request, Closure $next)
    {
        throw new PermissionDenied(__('user'));

        return $next($request);
    }
}
