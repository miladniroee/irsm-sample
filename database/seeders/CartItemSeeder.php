<?php

namespace Database\Seeders;

use App\Enums\ProductType;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);
        $products = Product::take(10)->get();

        foreach ($products as $product) {
            CartItem::create([
                'user_id' => $user->id,
                'variation_id' => $product->variations->random()->id,
                'quantity' => rand(1, 5),
            ]);
        }
    }
}
