<?php

namespace Database\Factories;

use App\Enum\PlatformTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductProperties>
 */
class ProductPropertiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'property_name' => fake()->randomElement(['Reels', 'Stories', 'Post']),
            'platform_id'   => rand(1, count(PlatformTypes::cases())),
        ];
    }
}
