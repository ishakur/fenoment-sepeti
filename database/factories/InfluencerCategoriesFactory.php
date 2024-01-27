<?php

namespace Database\Factories;

use App\Enum\CategoryTypes;
use App\Enum\PlatformTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InfluencerCategories>
 */
class InfluencerCategoriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'influencer_id' => rand(1, 5),
            'category_id'   => rand(1, count(CategoryTypes::cases()) - 1),
        ];
    }
}
