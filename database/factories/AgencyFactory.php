<?php

namespace Database\Factories;

use App\Enum\UserTypes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agency>
 */
class AgencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user=User::factory()->create(['userType' => UserTypes::Agency]);


        return [
            'userID' => $user->userID,
            'agencyName' => $this->faker->name,
            'agencyAddress' => $this->faker->address,
            'taxNumber' => mt_rand(10000000000, 99999999999),
        ];
    }
}
