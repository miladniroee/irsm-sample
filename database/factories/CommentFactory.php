<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_name' => $this->faker->name,
            'author_email' => $this->faker->email,
            'author_url' => $this->faker->url,
            'author_ip' => $this->faker->ipv4,
            'rating' => $this->faker->numberBetween(1, 5),
            'body' => $this->faker->paragraph,
            'is_approved' => $this->faker->boolean(80),
        ];
    }
}
