<?php

namespace Database\Factories;

use App\Enum\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItems>
 */
class OrderItemsFactory extends Factory
{
    /**
     * Sepetteki urunlerin bilgilerini burada olusturuyoruz
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'order_id'            => $this->faker->numberBetween(1, 10),
            'seller_id'           => $this->faker->numberBetween(1, 10),
            'product_id'          => $this->faker->numberBetween(1, 10),
            'seller_confirmation' => $this->faker->randomElement([true, false]),
            'status'              => $this->faker->randomElement(['OnChart','ActiveOrder','OrderCompleted']),
            'ad_duration'         => $this->faker->numberBetween(1, 10),
            'ad_total_price'      => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
