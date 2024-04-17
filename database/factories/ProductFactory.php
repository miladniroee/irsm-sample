<?php

namespace Database\Factories;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $sale_price = $this->faker->randomElement([null, $this->faker->numberBetween(1000, 1000000)]);
        $stock = $this->faker->randomElement([0, $this->faker->numberBetween(0, 100)]);
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'type' => $this->faker->randomElement([ProductType::Fixed->value, ProductType::Variable->value]),
            'excerpt' => $this->faker->text,
            'description' => $this->faker->text,
            'price' => $this->faker->numberBetween(1000, 1000000),
            'sale_price' => $sale_price,
            'featured' => !!$sale_price,
            'stock_quantity' => $stock,
            'in_stock' => !!$stock,
            'view_count' => $this->faker->numberBetween(0, 100),
            'rating_count' => $this->faker->numberBetween(0, 100),
            'average_rating' => $this->faker->numberBetween(0, 100),
            'total_sales' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['pending','draft', 'published']),
            'brand_id' => $this->faker->numberBetween(1, 5),
            'user_id' => $this->faker->numberBetween(1, 5),
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
