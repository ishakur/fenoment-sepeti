<?php

namespace Database\Factories;

use App\Enum\UserTypes;
use App\Models\Influencer;
use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Influencer>
 */
class InfluencerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

//        $user = User::factory()->create([
//                                            'userType' => UserTypes::Influencer,
//                                        ]);


        return [
            'userID'            => null,
            'agencyID'          => null,
            'platformUserName'  => $this->faker->userName,
            'bannerPhoto'       => 'assets/images/gamzePP.jpeg',
            'fenocityPoint'     => mt_rand(1, 5),
            'fenocitySaleCount' => mt_rand(100, 1000),
            'bioVerifyCode'     => $this->faker->regexify('[A-Z]{10}[0-4]{5}'),
            'infVerify'         => true,
            'statsVerify'       => true,
            'isInfDeleted'      => false,
            'taxPayer'          => true,
        ];

    }
}
