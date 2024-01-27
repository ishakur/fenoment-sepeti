<?php

namespace App\Http\Middleware\Api\Auth;

use App\Enum\UserTypes;
use App\Exceptions\NotFound;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckBannedOrDeletedNonAuth
{
    /**
     * Handle an incoming request.
     *
     * //     * @param LoginRequest $request
     * //     * @param \Closure(LoginRequest): (Response|RedirectResponse) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
                               'email' => 'required|email|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9._]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/',
                           ]);
        $user = User::whereEmail($request->email)->first();
        if (!$user)
            throw new ModelNotFoundException('user');

        if ($user->userType == UserTypes::Deleted || $user->userType == UserTypes::Banned)
            throw new NotFound(ApiController::getTextFromControllerLanguageFile('user'));


        return $next($request);
    }
}

