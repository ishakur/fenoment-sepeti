<?php

namespace Database\Factories;

use App\Enum\PlatformTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'influencer_id'      => rand(1, 5),
            'product_property_id' => rand(1, count(PlatformTypes::cases())),
            'price_for_per_minute' => rand(1, 1000)/10,
            ];
    }
}
