<?php

namespace Tests\Feature;

use App\Enum\UserTypes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BaseUserClass;

class InfluencerTest extends BaseUserClass
{
    use RefreshDatabase;

    public function testInfluencerRegisterAndLogin()
    {
//        $this->seed(InfluencerSeeder::class);
        //bagimliliklari eklemeden once seed etmemiz gerekiyor
        $data = [
            'userType'    => UserTypes::Influencer,
            'nameSurname' => 'FTA',
            'email'       => fake()->unique()->safeEmail(),
            'password'    => 'Wer321wer$',
            //            'platformUserName'      => 'FTA',
        ];

//        $this->artisan('db:seed', ['--class' => CategorySeeder::class]);
        $this->register($data);

        $this->login($data, 401, false);

        $this->emailVerificationSelf($data);

        $this->login($data)['data']['access_token'];

        //TODO influencer Test
    }

}
