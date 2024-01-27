<?php

namespace App\Http\Middleware\Api\Influencer;

use App\Enum\UserTypes;
use App\Exceptions\PermissionDenied;
use App\Http\Controllers\Api\ApiController;
use App\Models\Agency;
use App\Models\Influencer;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserTypeWhenInfluencerDestroy
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request                                                                          $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return match (User::where('userID', Auth::id())->first()->userType) {

            UserTypes::Admin      => $next($request),

            UserTypes::Influencer => call_user_func(function () use ($request, $next) {

                $user       = User::where('userID', Auth::id())->first();
                $influencer = Influencer::where('userID', $user->userID)->first();

                if ($influencer->userID == $request->route('influencer')) {
                    return $next($request);
                }

                throw new PermissionDenied(__('influencer'));
            }),

            UserTypes::Agency     => call_user_func(function () use ($request, $next) {

                $agency     = Agency::where('userID', Auth::id())->first();
                $influencer = Influencer::where('infID', $request->route('influencer'))->first();

                if ($influencer->agencyID == $agency->agencyID) {
                    return $next($request);
                }

                throw new PermissionDenied(__('influencer'));
            }),

            default                     => throw new PermissionDenied(__('influencer'))

        };
    }
}
