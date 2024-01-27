<?php

namespace App\Http\Middleware\Api\Auth;

use App\Exceptions\EmailNotVerified;
use App\Http\Middleware\Api\ResponseClass;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class isEmailVerifiedNonAuth extends ResponseClass
{
    /**
     * Handle an incoming request.
     *
     * //     * @param LoginRequest $request
     * //     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     */
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
                               'email' => 'required|email|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9._]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/',
                           ]);

        $user = User::whereEmail($request->email)->first();
        if (!$user)
            throw new ModelNotFoundException('user');

        if (!$user->userVerifications->eMailVerify)
            throw new EmailNotVerified();

        return $next($request);
    }
}
