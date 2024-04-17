<?php

namespace Database\Factories;

use App\Enums\AttachmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'path' => $this->faker->imageUrl(),
            'type' => AttachmentType::Image->value,
            'is_thumbnail' => $this->faker->boolean(20),
        ];
    }
}
