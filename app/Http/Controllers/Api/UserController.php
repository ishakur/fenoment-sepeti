<?php

namespace App\Http\Controllers\Api;

use App\Enum\Http;
use App\Exceptions\EmailNotVerified;
use App\Exceptions\NotFound;
use App\Exceptions\StoreFailed;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\EmailRequireRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUser;
use App\Http\Requests\VerifyRequest;
use App\Http\Resources\UserResource;
use App\Mail\VerifyMail;
use App\Models\User;
use App\Models\UserTemporaryVerificationCodes;
use App\Models\UserVerifications;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\Client\Credentials\Container;
use Vonage\SMS\Message\SMS;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;


class UserController extends ApiController
{


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $users = User::with('userVerifications')->get()->take(10);
//        return $users;


        if ($users->count() > 0)
            throw new NotFound('users');

        return $this->apiResponse(UserResource::collection($users),
                                  $this->getTextFromControllerLanguageFile('showSuccess', 'users'),
                                  200,
        );

    }

    /**
     *
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     */
    public function store(RegisterRequest $request)
    {
        $user = User::createUser($request);
        if (!$user)
            throw new StoreFailed('user');
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     */
    public function show(Request $request)
    {

        $user = User::find($request->userID);

        if (!$user)
            throw new NotFound('user');

        return $this->apiResponse(new UserResource($user), $this->getTextFromControllerLanguageFile('showSuccess', 'user'), 200);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUser $request
     * @param User       $user
     *
     */
    public function update(UpdateUser $request)
    {
        $user = User::updateUser($request);
        if (!$user)
            throw new NotFound('user');

        return $this->apiResponse(new UserResource($user), $this->getTextFromControllerLanguageFile('updateSuccess', 'user'), 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     */

    public
    function destroy(Request $request)
    {

        $user = User::find($request->userID);
        if (!$user)
            throw new NotFound('user');

        $user->deleteUser($user);
        app(AuthController::class)->logout($request);

        return $this->apiResponse($user->nameSurname, $this->getTextFromControllerLanguageFile('deleteSuccess', 'user'), 200);


    }

    public
    function smsSendCustomMessage()
    {
        //        $messageContent = 'Test Message';
        //        try {
        //            $user = auth()->user();
        //            $user->notify(new SmsSentCustomMessage($user, $messageContent));
        //            return $this->apiResponse(null, 'SMS sent success', 200);
        //        } catch (Exception $exception) {
        //            return $this->apiResponse(null, $exception->getMessage(), 409);
        //        }
    }

    public
    function smsSendVerificationCode()
    {

        $user              = auth()->user();
        $userVerifications = $user->userVerifications;
        //TODO userTemporaryVerificationCodes eger userin tablosu yoksa olustur varsa id al devam et. bu methodun duzenlenmesi gerekiyor
        $userTemporaryVerificationCodes = $user->userTemporaryVerificationCodes;
        return [$userTemporaryVerificationCodes, $userVerifications];
        //vonage sms framework vonage api key ve secretini .env dosyasini kullanarak aliyoruz
        $basic  = new Basic(env('VONAGE_KEY'), env('VONAGE_SECRET'));
        $client = new Client(new Container($basic));
        //sms ile gidecek kodu random olarak olusturuyoruz
        $code = rand(1000, 9999);


        //smsimizi kodline adiyla gonderiyoruz
        $response = $client->sms()->send(
            new SMS(  $this->getTextFromKeywordsLanguageFile($userVerifications->phoneNumber),
                      env('APP_NAME'),
                      $this->getTextFromAuthLanguageFile('verificationCodeIs', $code),
                type: 'unicode'),
        );

        //eger sms gonderimi basariliysa, userin phoneVerifyCode  alanlarini guncelle
        if ($response->current()->getStatus() == 0) {
            $user->phoneVerifyCode       = $code;
            $user->phoneVerifyCodeExpire = now()->addMinutes(5);
            $user->save();
            return $this->apiResponse(null, $this->getTextFromAuthLanguageFile('verificationCodeSuccess'), 200);
        } else {
            return $this->apiResponse(null, $this->getTextFromAuthLanguageFile('verificationCodeFailed'), 409);
        }
    }

    public
    function verifyPhone(VerifyRequest $request)
    {
        $user = auth()->user();

        //eger dogrulama kodu dogruysa ve dogrulama gecerlilik tarihi suandan buyukse yani gecerliyse,  userin phoneVerify ve phoneVerifyDate alanlarini guncelle
        if ($user->phoneVerifyCodeExpire > date('Y-m-d H:i:s') && $user->phoneVerifyCode == $request->verificationCode) {
            $user->phoneVerify     = true;
            $user->phoneVerifyDate = now();
            $user->save();
            return $this->apiResponse(null, $this->getTextFromAuthLanguageFile('verifySuccess'), 200);
        } else {
            return $this->apiResponse(null, $this->getTextFromAuthLanguageFile('somethingWentWrong'), 409);
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public
    function forgotPassword(Request $request)
    {
        $request->validate([
                               'email' => 'required|email',
                           ]);
        $status = Password::sendResetLink(
            $request->only('email'),
        );
        if ($status == Password::RESET_LINK_SENT) {
            return ['status' => __($status)];
        }
        throw ValidationException::withMessages([
                                                    'email' => [trans($status)],
                                                ]);
    }

    public
    function resetPassword(Request $request)
    {
        $request->validate([
                               'token'    => 'required',
                               'email'    => 'required|email',
                               'password' => 'required|confirmed',
                           ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                                     'password'       => Hash::make($request->password),
                                     'remember_token' => Str::random(60),
                                 ])->save();
                event(new PasswordReset($user));
            },
        );
        if ($status == Password::PASSWORD_RESET) {
            return response([
                                'message' => $this->getTextFromAuthLanguageFile('userPasswordResetSuccess'),
                            ]);
        }
        return response([
                            'message' => __($status),
                        ], 500);
    }

    /**
     * @param User $user
     *
     * @return JsonResponse
     * @throws Exception
     */

    public
    function reSendVerifyEmail(EmailRequireRequest $request)
    {
        $request->validate([
                               'email' => 'required|email',
                           ]);
        $isSuccess = $this->sendVerifyEmail(null, $request);
        if (!$isSuccess)
            self::apiResponse(null, $this->getTextFromAuthLanguageFile('emailVerificationSentFailed'), 409);

        self::apiResponse(null, $this->getTextFromAuthLanguageFile('emailVerificationSentAgain'), 200);

    }

    public
    function sendVerifyEmail(User $user = null, Request $request = null)
    {
        if ($request != null) {
            $user = User::whereEmail($request->email)->firstOrFail();
        }

        //eger userin emaili dogrulanmissa ve , dogrulama kodu gonderme
        $userVerifications = UserVerifications::where(['userID' => $user->userID])->firstOrFail();

        if ($userVerifications->eMailLastCodeSendDate > now()) {
            $seconds = strtotime($userVerifications->eMailLastCodeSendDate) - time();
            throw new Exception($this->getTextFromAuthLanguageFile('throttle'), 409);
        }

        if ($userVerifications->eMailVerify) {
            throw new Exception($this->getTextFromAuthLanguageFile('emailAlreadyVerified'), 409,);
        }


        $verificationCode                            = mt_rand(100000, 999999);
        $userTemporaryVerificationCodes              = UserTemporaryVerificationCodes::firstOrNew(['userID' => $user->userID]);
        $userTemporaryVerificationCodes->userID      = $user->userID;
        $userTemporaryVerificationCodes->code        = $verificationCode;
        $userTemporaryVerificationCodes->expire_date = now()->addMinutes(3);
        //if test mode is true, send verification code to test email
        Mail::to($user)->send(new VerifyMail($user, $verificationCode));


//            $userVerifications->eMailLastCodeSendDate = now()->addMinute(3);
        $userVerifications->save();
        $userTemporaryVerificationCodes->save();

        return true;
//        if (!$sendMail) {
//
//            if (Influencer::where('userID', $user->userID)->first()) {
//                InfAccountPropertyController::where('infID', Influencer::where('userID', $user->userID)->first()->infID)->delete();
//                Influencer::where('userID', $user->userID)->delete();
//            } else if (Agency::where('userID', $user->userID)->first()) {
//                Agency::where('userID', $user->userID)->delete();
//            } else if (CorpAdvertiser::where('userID', $user->userID)->first()) {
//                CorpAdvertiser::where('userID', $user->userID)->delete();
//            }
//            $user->delete();
//            throw new Exception('Verification mail could not be send. Please try again later.');
//        }
    }

    /**
     * @param $verificationCode
     *
     * @return JsonResponse
     */
    public
    function verifyEmail(EmailRequireRequest $request)
    {
        //user ve verification kodu dogrulama bilgilerini cekiyoruz yoksa hata donuyoruz
        $user              = User::whereEmail($request->email)->firstOrFail();
        $userVerifications = $user->userVerifications;
        //bu email zaten dogrulanmis ise
        if ($userVerifications->eMailVerify)
            throw new EmailNotVerified();
//                return $this->apiResponse(null, 'Your email already verified', 409);


        //eger dogrulama kodu expire date gecerliyse ve dogrulama kodu dogruysa
        $verificationCode               = $request->verificationCode;
        $userTemporaryVerificationCodes = UserTemporaryVerificationCodes::where('userID', $user->userID)->firstOrFail();
        if ($userTemporaryVerificationCodes->code != $verificationCode || $userTemporaryVerificationCodes->expire_date < now())
            throw new Exception($this->getTextFromAuthLanguageFile('invalidEmailVerificationCode'), 409);


        //userin emailini dogrula
        $userVerifications->eMailVerify();

        //ve dogrulama kodunu sil
        $userTemporaryVerificationCodes->delete();

        return $this->apiResponse(null, $this->getTextFromAuthLanguageFile('emailVerificationSuccess'), 200);
    }

    public
    function redirectToPlatformRegister($platformTypes)
    {
        try {
            return self::apiResponse(Socialite::driver($platformTypes)->redirect()->getTargetUrl(),
                                     $this->getTextFromControllerLanguageFile('redirectingToPlatform', 'platformTypes'),
                                     200);
        } catch (Exception) {
            return self::apiResponse(null,
                                     $this->getTextFromControllerLanguageFile('redirectingToPlatformFailed', 'platformTypes'),
                                     Http::BAD_REQUEST);
        }
    }

    public
    function handleGoogleCallback(Request $request)
    {
//
//        $user = Socialite::driver('google')->user();
//
////        dd($request->userType);
//        if ($user)
//            return $this->apiResponse(null,$this->getTextFromControllerLanguageFile('showSuccess', 'user'), 200);
//
//        else
//            return $this->apiResponse(null,$this->getTextFromControllerLanguageFile('showFailed', 'user'), 409);
//

    }/**/
    public
    function getImage($fileName)
    {
        $path = storage_path() . '/app/assets/images/' . $fileName;
        if (!File::exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;

    }

    public function storeImageToCloud($image)
    {
        //TODO: image upload to cloud
    }
}
