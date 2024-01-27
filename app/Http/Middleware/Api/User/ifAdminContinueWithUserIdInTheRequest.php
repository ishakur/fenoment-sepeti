<?php

namespace App\Http\Middleware\Api\User;

use App\Enum\UserTypes;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ifAdminContinueWithUserIdInTheRequest
{
    /**
     * Handle an incoming request.
     *
     * //     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        //admin ise
        if ($user->isAdmin() && $request->userID != null)
            return $next($request);

        $request->merge(['userID' => $user->userID]);

        return $next($request);
    }
}
