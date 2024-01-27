<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InfAccountProperties>
 */
class InfAccountPropertiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'platformUserName'=>$this->faker->userName,
            'followerCount'=>rand(100, 1000),
            'followingCount'=>rand(100, 1000),
            'mediaCount'=>rand(100, 1000),
            'avarageLikeCount'=>rand(100, 1000),
            'avarageViewCount'=>rand(100, 1000),
            'storyViewCount'=>rand(100, 1000),
            'reachedAccountCount'=>rand(1, 100),
            'enagagedAccountCount'=>rand(100, 1000),
            'saveCount'=>rand(100, 1000),
            'shareCount'=>rand(0, 1),
            'socialVerify'=>rand(0, 1),
        ];
    }
}
