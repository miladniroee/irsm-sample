<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariation>
 */
class ProductVariationFactory extends Factory
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
            'price' => $this->faker->numberBetween(1000, 1000000),
            'sale_price' => $sale_price,
            'sku' => $this->faker->numberBetween(100000, 999999),
            'stock_quantity' => $stock,
            'in_stock' => !!$stock,
            'featured' => !!$sale_price,
            'product_id' => 1,
            'total_sales' => $this->faker->numberBetween(0, 100),
            'store_id' => $this->faker->numberBetween(1, 5),
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
