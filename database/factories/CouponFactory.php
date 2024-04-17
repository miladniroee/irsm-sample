<?php

namespace Database\Factories;

use App\Enums\CouponType;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(CouponType::cases());

        $amount = match ($type) {
            CouponType::FixedCard, CouponType::FixedProduct => $this->faker->randomNumber(8),
            CouponType::Percent => $this->faker->randomFloat(2, 0, 100),
        };

        $usageLimit = $this->faker->numberBetween(1, 100);

        $rand = $this->faker->numberBetween(1, 5);

        $ArrayData = [
            'products' => NULL,
            'product_categories' => NULL,
            'product_brands' => NULL,
            'seller_ids' => NULL,
            'user_ids' => NULL,
        ];

        switch ($rand) {
            case 1:
                $ArrayData['products'] = Product::take(3)->pluck('id')->toArray();
                break;
            case 2:
                $ArrayData['product_categories'] = Category::shop()->take(3)->pluck('id')->toArray();
                break;
            case 3:
                $ArrayData['product_brands'] = Brand::take(3)->pluck('id')->toArray();
                break;
            case 4:
                $ArrayData['seller_ids'] = [1, 2, 3];
                break;
            case 5:
                $ArrayData['user_ids'] = [1, 2, 3];
                break;
        }

        return [
            'code' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'amount' => $amount,
            'type' => $type,
            'usage_count' => $this->faker->numberBetween(0, $usageLimit),
            'usage_limit' => $usageLimit,
            'usage_limit_per_user' => $this->faker->randomElement([null, $this->faker->numberBetween(1, 10)]),
            'expires_at' => $this->faker->randomElement([null, $this->faker->dateTimeBetween('now', '+1 year')]),
            'free_shipping' => $this->faker->boolean(30),
            'exclude_sale_items' => $this->faker->boolean(30),
            'minimum_amount' => $this->faker->randomElement([null, $this->faker->randomNumber(8)]),
            'maximum_amount' => $this->faker->randomElement([null, $this->faker->randomNumber(8)]),
            'maximum_discount_amount' => $this->faker->randomElement([null, $this->faker->randomNumber(8)]),
            ...$ArrayData,
        ];
    }
}
