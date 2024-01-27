<?php

namespace Tests;

use App\Http\Controllers\Api\UserController;
use App\Models\User;
use App\Models\UserTemporaryVerificationCodes;


use  Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class BaseUserClass extends TestCase
{
    //ram uzerindeki sqlite'a migrateleri tamamliyor
    //    use RefreshDatabase;

    /**
     * User Register Test Case
     *
     * @return void
     */
    public function register($data): void
    {
        // register route'una post ediyorum
        $response = $this->postJson('api/register', $data);


//         gelen response status 201 ise ve success true ise test basarili

        $response->assertStatus(201)
                 ->assertJson([
                                  'success' => true,
                              ],
                 );
        //        $this->assertContains($data['email'],$response->json());


    }

    /**
     * User Login Test Case
     *
     * @return void
     */
    public function login($data, $status = 200, $success = true): array
    {
        $response = $this->postJson('api/login', $data);

        // gelen response status 201 ise ve success true ise test basarili
        $response->assertStatus($status)
                 ->assertJson([
                                  'success' => $success,
                              ],
                 );


        return $response->json();
    }

    public function emailVerificationSelf($data)
    {
        $user = User::where('email', $data['email'])->first();

        $userController = new UserController();
        try {
            $userController->sendVerifyEmail($user, null);
        } catch (\Exception $e) {

        }


        $userVerifications = UserTemporaryVerificationCodes::where('userID', $user->userID)->first();
        $response          = $this->postJson('api/verify-email', ['email' => $user->email, 'verificationCode' => $userVerifications->code]);

        $response->assertStatus(200)
                 ->assertJson([
                                  'success' => true,
                              ],
                 );
    }

    public function updateSelf($data)
    {
        $data['nameSurname'] = fake()->name;
        $data['email']       = fake()->unique()->safeEmail();
//        $data['profilePhoto'] = 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png';
//        $data['phoneNumber']  = mt_rand(5000000000, 5999999999);

        //TODO ADD EMAIL , PASSWORD , PHONE NUMBER ,PROFILE IMAGE

        $response = $this->postJson('api/users/update', $data);

        $response->assertStatus(200)
                 ->assertJson([
                                  'success' => true,
                                  'data'    => [
                                      'nameSurname' => $data['nameSurname'],
                                      'email'       => $data['email'],
                                      //                                                                            'phoneNumber'=>str($data['phoneNumber']),
                                  ],
                              ],
                 );

    }

    public function logout()
    {
        //TODO LOGOUT
    }

    public function deleteSelf()
    {
        //TODO  DELETE SELF USER
    }

    public function getSelf($data)
    {

        $data['nameSurname'] = fake()->name;
        $data['email']       = fake()->unique()->safeEmail();
        $headers             = $data['headers'];
        $this->transformHeadersToServerVars($headers);
        $response = $this->postJson('api/users/update', $data);

        $response->assertStatus(200);
    }

    public function passwordResetSelf()
    {
        //TODO PASSWORD RESET SELF USER

    }

    public function smsVerificationSelf()
    {
        //TODO SMS VERIFICATION SELF USER

    }

    public function sendSms()
    {
        //TODO SEND SMS
    }

    public function resetPassword()
    {
        //TODO RESET PASSWORD
    }

    public function getSelfOrders($count, $data)
    {
        //TODO GET SELF ORDERS
        $response = $this->getJson('api/all-basket', $data);

        $response->assertStatus(200)
                 ->assertJson([
                                  'success' => true,
                              ],
                 )->assertJsonCount($count, 'data');
    }

    public function basketDeleteSelf($basketItemId)
    {
        $response = $this->delete('api/basket/' . $basketItemId);

        $response->assertStatus(200)
                 ->assertJson([
                                  'success' => true,
                              ],
                 );
    }

    public function basketGetSelf()
    {
        //TODO GET SELF CART
    }

    public function basketCheckOut()
    {
        //TODO ORDER CHECKOUT
    }

    public function basketAddProduct()
    {
        $response = $this->postJson('api/basket', [
            'productId'  => 1,
            "adDuration" => 2,
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                                  'success' => true,
                                  'data'    => [
                                      'product' => [
                                          'product_id' => 1,
                                      ],

                                  ],
                              ],
                 );

        return ($response->json()['data']['id']);
    }

    public function basketUnload() {}

    public function getAllInfluencers()
    {
        //TODO tum user tipleri burada erisebilir
    }

    public function getAllAgencies()
    {
        //TODO burada hicbir sekilde userin erisememesi gerekir yalnizca ajansin ve adminin erisimine acilmali
    }

    public function getAllCorpAdvertisers()
    {
        //TODO burada hicbir sekilde userin erisememesi gerekir yalnizca ajansin ve adminin erisimine acilmali
    }

}
