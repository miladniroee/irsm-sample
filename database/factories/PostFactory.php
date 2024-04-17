<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug,
            'title' => $this->faker->sentence,
            'user_id' => 1,
            'excerpt' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'thumbnail' => null,
            'views' => Random::generate(2, '0-9'),
            'comments' => Random::generate(1, '0-9'),
            'published' => true,
        ];
    }
}
