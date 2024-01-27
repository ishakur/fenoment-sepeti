<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\InfluencerSeeder;
use Database\Seeders\UserSeeder;
use Tests\BaseUserClass;

class UserTest extends BaseUserClass
{
    public function testSequence()
    {
//        $this->seed(DatabaseSeeder::class);
//        $this->seed(CategorySeeder::class);
//        $this->seed(InfluencerSeeder::class);
//        $this->seed(AdminSeeder::class);
//
//        $this->assertTrue(Schema::hasTable('users'));
//        $this->assertTrue(Schema::hasTable('categories'));78
//        $this->assertTrue(Schema::hasTable('influencers'));
//        $this->assertTrue(Schema::hasTable('admins'));
//
//        $this->assertTrue(Category::count() > 0);
//        $this->assertTrue(User::count() > 0);
//
//        $user = $this->createUser();
//        $this->updateUser($user);
//        $this->deleteUser($user);
//        $this->getUser($user);

//        random degerlerde bir user olusturuyorum
        $this->seed(UserSeeder::class);
        $this->seed(InfluencerSeeder::class);

        $data = [
            'userType'    => 'User',
            'nameSurname' => 'FTA',
            'email'       => 'user@farukaydogan.com',
            'password'    => 'Wer321wer$',
        ];

        $this->register($data);
        //email verify olmadan login olmamali
        $this->login($data, 401, false);
//        email dogrulama yapiliyor
        $this->emailVerificationSelf($data);


        $jwt = $this->login($data)['data']['access_token'];

        $data['headers'] = [
            "Accept"        => "application/json",
            "X-CSRF-TOKEN"  => "",
            'Authorization' => 'Bearer ' . $jwt,
        ];

        $this->getSelf($data);

        //user update ediliyor

        $this->updateSelf($data);

        $this->getSelfOrders(1, $data);

        $basketItemId = $this->basketAddProduct();

        $this->basketCheckOut();

        $this->basketGetSelf();

        $this->basketDeleteSelf($basketItemId);

        $this->basketUnload();

//        $this->getSelfOrders(1);


        //TODO influencer tests

        //TODO unauthorized test for different user private access
    }

}