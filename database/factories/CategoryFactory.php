<?php

namespace Database\Factories;

use App\Enum\CategoryTypes;
use App\Models\InfluencerCategories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randomCategoryType = CategoryTypes::cases()[rand(0, count(CategoryTypes::cases()) - 1)];

        return [
            'category_name'   => $randomCategoryType,
            'slug'            => Str::slug($randomCategoryType),
            'category_up'     => 0,
            'category_rank'   => 0,
            'category_icon'   => 'icon',
            'category_status' => true,
        ];
    }
}
