<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserVerificationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'userID'          => null,
            'phoneNumber'     => mt_rand(5000000000, 5999999999),
            'eMailVerify'     => fake()->randomElement([true, false]),
            'phoneVerify'     => fake()->randomElement([true, false]),
            'eMailVerifyDate' => fake()->dateTime(),
            'phoneVerifyDate' => fake()->dateTime(),
            'lastLoginDate'   => fake()->dateTime(),
            'registerDate'    => fake()->dateTime(),
        ];
    }
}
