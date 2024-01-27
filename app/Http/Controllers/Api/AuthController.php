<?php

namespace App\Http\Controllers\Api;

use App\Enum\UserTypes;
use App\Exceptions\AlreadyExist;
use App\Exceptions\EmailOrPasswordIncorrect;
use App\Exceptions\NotFound;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use PharIo\Manifest\InvalidEmailException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends ApiController
{
    /**
     * API Register
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Get(
     *     path="/api/data.json",
     *     @OA\Response(
     *         response="200",
     *         description="The data"
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {

        //user daha once kayit olduysa ve email onayi yapilmis ise
        $user = User::where('email', $request->email)->first();
        if ($user && $user->userVerifications->eMailVerify == 1)
            throw new AlreadyExist('email');

        //user daha once kayit olduysa ancak email onayi yapilmadiysa
        else if ($user && $user->userVerifications->eMailVerify == 0)
            $user = User::registerUpdate($request);

        //user ilk kez kayit olduysa
        else
            $user = app(UserController::class)->store($request);


//            if ($request->userType == UserTypes::CorpAdvertiser->name) {
//                $corpStoreRequest = (new StoreCorpAdvertiserRequest())->merge($request->all());
//                app(CorpAdvertiserController::class)->store($corpStoreRequest, $user);
//            } else if ($request->userType == UserTypes::Influencer->name) {
//                $infStoreRequest = (new Request())->merge($request->all());
//                app(InfluencerController::class)->store($infStoreRequest, $user);
//            } else if ($request->userType == UserTypes::Agency->name) {
//                $agencyStoreRequest = (new StoreAgencyRequest())->merge($request->all());
//                app(AgencyController::class)->store($agencyStoreRequest, $user);
//            }

        //eger google veya facebook ile giris yapilmadiysa
        if ($request->googleId == null && $request->facebookId == null)
            app(UserController::class)->sendVerifyEmail($user, $request);
        else if ($request->googleId != null)
            $user->eMailVerify();

        return $this->apiResponse(new UserResource($user),
                                  $this->getTextFromAuthLanguageFile('registerSuccess'),
                                  201);


    }

    /**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user              = User::whereEmail($request->email)->first();
        $userVerifications = $user->userVerifications;

        if (isset($request->password)) {
            //sifre dogru degil ise
            $credentials = [
                'email'    => $request->email,
                'password' => $request->password,
            ];
            if (!Hash::check($request->password, $user->password))
                throw new EmailOrPasswordIncorrect();

            //sifre dogru ise
            $token = auth()->attempt($credentials);
        } else if (isset($request->googleId)) {
            //google id Yanlis ise
            if (!Hash::check($request->googleId, $userVerifications->googleId))
                throw new EmailOrPasswordIncorrect();

            //google id dogru ise
            $userVerifications->lastLoginDate = now();
            $userVerifications->save();
            $token = JWTAuth::fromUser($user);
        } else {
            throw new EmailOrPasswordIncorrect();
        }
        return $this->respondWithToken($userVerifications->eMailVerify, $token);
    }

    //
    private function respondWithToken($emailVerify, $token)
    {

        JWTAuth::factory()->setTTL(0.25);

        return $this->apiResponse([
                                      'access_token' => $token,
                                      'token_type'   => 'Bearer',
                                      //time zone eklenecek
                                      'expires_in'   => (time() * 1000) + (env('JWT_TTL') * 60 * 1000),
                                      'eMailVerify'  => $emailVerify == 1,
                                  ], $this->getTextFromAuthLanguageFile('loginSuccess'), 200);

    }

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout()
    {
        auth()->logout();
        return $this->apiResponse(null, $this->getTextFromAuthLanguageFile('logoutSuccess'), 200);
    }


    public function refresh(Request $request)
    {
        $refreshed = JWTAuth::refresh(JWTAuth::getToken());
        return $this->apiResponse($refreshed, $this->getTextFromAuthLanguageFile('tokenRefreshSuccess'), 200);
    }

    /**
     * API Recover Password
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recover(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user == null)
            throw new NotFound('user');

        $pass = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject(self::getTextFromControllerLanguageFile('yourPasswordResetLink'));
        });

        if ($pass == Password::RESET_LINK_SENT) {
            return $this->apiResponse(null, $this->getTextFromAuthLanguageFile('tokenRefreshSuccess'), 200);
        } else {
            throw new EmailOrPasswordIncorrect();
        }

    }
}
