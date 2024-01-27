<?php

namespace Database\Factories;

use App\Enum\UserTypes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Corpadvertiser>
 */
class CorpAdvertiserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create(['userType' => UserTypes::CorpAdvertiser]);

        $user->userVerifications()->createMany([
                                                   [
                                                       'phoneNumber'     => mt_rand(5000000000, 5999999999),
                                                       'eMailVerify'     => fake()->randomElement([true, false]),
                                                       'phoneVerify'     => fake()->randomElement([true, false]),
                                                       'eMailVerifyDate' => fake()->dateTime(),
                                                       'phoneVerifyDate' => fake()->dateTime(),
                                                       'lastLoginDate'   => fake()->dateTime(),
                                                       'registerDate'    => fake()->dateTime(),
                                                   ],
                                               ]);

        return [
            'userID'         => $user->userID,
            'corpAdvName'    => $this->faker->name(),
            'corpAdvAddress' => $this->faker->address(),
            'taxNumber'      => mt_rand(10000000000, 99999999999),
        ];
    }
}
