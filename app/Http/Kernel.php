<?php

namespace App\Http;

use App\Http\Middleware\Api\Admin\IsAdmin;
use App\Http\Middleware\Api\Auth\CheckBannedOrDeletedNonAuth;
use App\Http\Middleware\Api\Auth\CheckBannedOrDeletedWithAuth;
use App\Http\Middleware\Api\Auth\isEmailVerifiedNonAuth;
use App\Http\Middleware\Api\Auth\isEmailVerifiedWithAuth;
use App\Http\Middleware\Api\Influencer\CheckUserTypeWhenInfluencerDestroy;
use App\Http\Middleware\Api\Influencer\IsInfluencer;
use App\Http\Middleware\Api\Influencer\IsInfluencerCategoryExist;
use App\Http\Middleware\Api\IsCategoryExist;
use App\Http\Middleware\Api\IsOrderDetailExist;
use App\Http\Middleware\Api\IsOrderItemExist;
use App\Http\Middleware\Api\IsPlatformExist;
use App\Http\Middleware\Api\IsProductExist;
use App\Http\Middleware\Api\IsProductPropertyExist;
use App\Http\Middleware\Api\Order\ifAdminContinueWithOrderDetailIdInTheRequest;
use App\Http\Middleware\Api\Order\ifAdminContinueWithOrderItemIdInTheRequest;
use App\Http\Middleware\Api\Order\IsOrderDetailActiveForOrderItem;
use App\Http\Middleware\Api\User\ifAdminContinueWithUserIdInTheRequest;
use App\Http\Middleware\Api\User\IsUser;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\ValidateSignature;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\AuthenticateSession;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth'                                         => Authenticate::class,
        'auth.basic'                                   => AuthenticateWithBasicAuth::class,
        'auth.session'                                 => AuthenticateSession::class,
        'cache.headers'                                => SetCacheHeaders::class,
        'can'                                          => Authorize::class,
        'guest'                                        => RedirectIfAuthenticated::class,
        'password.confirm'                             => RequirePassword::class,
        'signed'                                       => ValidateSignature::class,
        'throttle'                                     => ThrottleRequests::class,
        'verified'                                     => EnsureEmailIsVerified::class,
        'checkUserTypeWhenInfluencerDestroy'           => CheckUserTypeWhenInfluencerDestroy::class,
        'checkBannedOrDeletedWithAuth'                 => CheckBannedOrDeletedWithAuth::class,
        'checkBannedOrDeletedNonAuth'                  => CheckBannedOrDeletedNonAuth::class,
        'ifAdminContinueWithUserIdInTheRequest'        => ifAdminContinueWithUserIdInTheRequest::class,
        'ifAdminContinueWithOrderDetailIdInTheRequest' => ifAdminContinueWithOrderDetailIdInTheRequest::class,
        'ifAdminContinueWithOrderItemIdInTheRequest'   => ifAdminContinueWithOrderItemIdInTheRequest::class,
        'isAdmin'                                      => IsAdmin::class,
        'isUser'                                       => isUser::class,
        'isInfluencer'                                 => IsInfluencer::class,
        'isInfluencerCategoryExist'                    => IsInfluencerCategoryExist::class,
        'isPlatformExist'                              => IsPlatformExist::class,
        'isCategoryExist'                              => IsCategoryExist::class,
        'isProductPropertyExist'                       => IsProductPropertyExist::class,
        'isProductExist'                               => IsProductExist::class,
        'isOrderDetailExist'                           => IsOrderDetailExist::class,
        'isOrderItemExist'                             => IsOrderItemExist::class,
        'isEmailVerifiedNonAuth'                       => isEmailVerifiedNonAuth::class,
        'isEmailVerifiedWithAuth'                      => isEmailVerifiedWithAuth::class,
        'isOrderDetailActiveForOrderItem'              => IsOrderDetailActiveForOrderItem::class,
        'jwt.auth'                                     => 'Tymon\JWTAuth\Middleware\GetUserFromToken',
        'jwt.refresh'                                  => 'Tymon\JWTAuth\Middleware\RefreshToken',
    ];
}
