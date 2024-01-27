<?php

namespace App\Exceptions;

use App\Enum\Http;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use PharIo\Manifest\Email;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class Handler extends JsonResponse
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {

        return match (true) {

            $exception instanceof ShowFailed                    => $this->apiResponse(null,
                                                                                      __('controller.showFailed',
                                                                                         ['attribute' => __('keywords.' . $exception->getMessage())]),
                                                                                      Http::BAD_REQUEST),

            $exception instanceof DeleteFailed                  => $this->apiResponse(null,
                                                                                      __('controller.deleteFailed',
                                                                                         ['attribute' => __('keywords.' . $exception->getMessage())]),
                                                                                      500),

            $exception instanceof AlreadyExist                  => $this->apiResponse(null,
                                                                                      __('controller.storeAlreadyExist',
                                                                                         ['attribute' => __('keywords.' . $exception->getMessage())]),
                                                                                      Http::UNAUTHORIZED),

            $exception instanceof UserNotDefinedException       => $this->apiResponse(null,
                                                                                      __('auth.userNotDefined'),
                                                                                      Http::UNAUTHORIZED),
            $exception instanceof TokenInvalidException         => $this->apiResponse(null,
                                                                                      __('auth.tokenInvalid'),
                                                                                      Http::UNAUTHORIZED),
            $exception instanceof JWTException                  => $this->apiResponse(null,
                                                                                      __('auth.tokenRefreshFailed'),
                                                                                      Http::UNAUTHORIZED),
            $exception instanceof EmailOrPasswordIncorrect      => $this->apiResponse(null,
                                                                                      __('auth.userPasswordOrMailIncorrect'),
                                                                                      Http::UNAUTHORIZED),
            $exception instanceof ModelNotFoundException        => $this->apiResponse(null,
                                                                                      __('controller.notFound',
                                                                                         ['attribute' => __('keywords.' . $exception->getMessage())]),
                                                                                      Http::UNAUTHORIZED),
            $exception instanceof NotFound                      => $this->apiResponse(null,
                                                                                      __('controller.notFound',
                                                                                         ['attribute' => __('keywords.' . $exception->getMessage())]),
                                                                                      404),
            $exception instanceof EmailNotVerified              => $this->apiResponse(null,
                                                                                      __('auth.emailVerificationRequired',),
                                                                                      Http::UNAUTHORIZED),
//            $exception instanceof EmailAlreadyVerified          => $this->apiResponse(null,
//                                                                                      __('auth.email_already_verified'),
//                                                                                      Http::UNAUTHORIZED),

            $exception instanceof AlreadySameData               => $this->apiResponse(null,
                                                                                      __('controller.alreadySameData',
                                                                                         ['attribute' => __('keywords.' . $exception->getMessage())]),
                                                                                      500),
            $exception instanceof PermissionDenied              => $this->apiResponse(null,
                                                                                      __('auth.permissionDenied', $exception->getMessage()),
                                                                                      403),

            $exception instanceof Empty_                        => $this->apiResponse(null,
                                                                                      __('controller.empty',
                                                                                         ['attribute' => __('keywords.' . $exception->getMessage())]),
                                                                                      410),
            $exception instanceof ValidationException           => $this->apiResponse(null,
                                                                                      $exception->getMessage(),
                                                                                      422),
            $exception instanceof AuthenticationException       => $this->apiResponse(null,
                                                                                      $exception->getMessage(),
                                                                                      401),
            $exception instanceof AuthorizationException        => $this->apiResponse(null,
                                                                                      $exception->getMessage(),
                                                                                      403),

            $exception instanceof MethodNotAllowedHttpException => $this->apiResponse(null,
                                                                                      $exception->getMessage(),
                                                                                      405),
            $exception instanceof TooManyRequestsHttpException  => $this->apiResponse(null,
                                                                                      $exception->getMessage
                                                                                      (),
                                                                                      429),
            $exception instanceof QueryException                => $this->apiResponse(null,
                                                                                      $exception->getMessage(),
                                                                                      500),

            $exception instanceof Exception                     => $this->apiResponse(null,
                                                                                      $exception->getMessage(),
                                                                                      500),

            default                                             => parent::render($request, $exception)
        };
    }
}
