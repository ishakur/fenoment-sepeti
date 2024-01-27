<?php

namespace Database\Factories;

use App\Enum\CategoryTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\navbar>
 */
class NavbarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = CategoryTypes::cases()[$this->faker->numberBetween(0, count(CategoryTypes::cases()) - 1)];
        return [
            'name'       => $name,
            'route_name' => $name . '/' . $this->faker->slug,
        ];
    }
}
