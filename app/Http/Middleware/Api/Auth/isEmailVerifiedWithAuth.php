<?php

namespace App\Http\Middleware\Api\Auth;

use App\Exceptions\EmailNotVerified;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\Api\ResponseClass;
use Closure;
use Illuminate\Http\Request;

class isEmailVerifiedWithAuth extends ResponseClass
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request                                                                          $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user->userVerifications->eMailVerify) {
            app(AuthController::class)->logout();
            throw new EmailNotVerified();
        }
        return $next($request);
    }
}
