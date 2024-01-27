<?php

namespace Database\Factories;

use App\Enum\UserTypes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [

            'nameSurname' => fake()->name(),
            'email'           => fake()->safeEmail(),
            'password' => bcrypt(fake()->password()), // password
            'userType' => UserTypes::User,
            'balance'=>0,
            'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/user.png',
            //userType random olarak secilmesi icin kullanilabilir
            //'userType' => fake()->randomElement(array_column(UserTypes::cases(),'value')),

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
