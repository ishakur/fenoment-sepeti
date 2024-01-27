<?php

namespace Database\Factories;

use App\Enum\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class OrderDetailsFactory extends Factory
{
    /**
     * Sepet olusturuyoruz satin alan kisi sepet tutari gibi bilgileri burada olusturuyoruz
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'purchaser_id' => $this->faker->numberBetween(1, 10),
            'status'       => fake()->randomElement(['OnChart', 'ActiveOrder', 'OrderCompleted']),
            'total_price'  => fake()->randomFloat(2, 0, 1000),
            'payment_id'   => $this->faker->numberBetween(1, 10),
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
        ]);
    }
}
