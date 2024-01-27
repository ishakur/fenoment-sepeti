<?php

namespace App\Http\Controllers;

use App\Enum\UserTypes;
use App\Exceptions\EmailNotVerified;
use App\Exceptions\EmailOrPasswordIncorrect;
use App\Exceptions\NotFound;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class LoginController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    public function login(LoginRequest $request)
    {

        $user = User::whereEmail($request->email)->with('userVerifications')->firstOrFail();

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,

        ];
        //kullanici silinmis veya banlanmis ise
        if ($user->userType == UserTypes::Banned && $user->userType == UserTypes::Deleted)
            throw new NotFound(__('controller.user'));

        //sifre yanlis ise
        if (!Hash::check($request->password, $user->password))
            throw new EmailOrPasswordIncorrect();

        //email dogrulanmamis ise
        if ($user->userVerifications->eMailVerify == 0)
            throw new EmailNotVerified();

        $token = auth()->attempt($credentials);


        return $this->respondWithToken($token);
    }

    public function guard()
    {
        return Auth::guard('api');
    }

    private function respondWithToken($token)
    {

        JWTAuth::factory()->setTTL(0.25);
        return $this->apiResponse([
                                      'access_token' => $token,
                                      'token_type'   => 'Bearer',
                                      //time zone eklenecek
                                      'expires_in'   => (time() * 1000) + (auth()->factory()->getTTL() * 60 * 1000),
                                      'eMailVerify'  => auth()->user()->eMailVerify == 1,
                                  ], __('auth.login_success'), 200);

    }


}
