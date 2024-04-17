<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'parent_id' => null,
            'description' => $this->faker->text,
            'posts_count' => $this->faker->numberBetween(0, 100),
            'image' => null,
            'type' => $this->faker->randomElement(['post', 'product']),
            'code' => $this->faker->numberBetween(100000, 999999),
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
