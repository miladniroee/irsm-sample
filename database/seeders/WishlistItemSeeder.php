<?php

namespace Database\Seeders;

use App\Enums\ProductType;
use App\Models\Product;
use App\Models\User;
use App\Models\WishlistItem;
use Illuminate\Database\Seeder;

class WishlistItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);
        $products = Product::take(5)->get();

        foreach ($products as $product) {
            WishlistItem::create([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
        }
    }
}
