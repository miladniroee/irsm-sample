<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{


    private array $mustSeed = [
        RoleSeeder::class,
        CategorySeeder::class,
        BrandSeeder::class,
        PaymentMethodSeeder::class
    ];

    private array $testSeed = [
        UserSeeder::class,
        StoreSeeder::class,
        VariationTypeSeeder::class,
        VariationSeeder::class,
        BlogSeeder::class,
        ProductSeeder::class,
        CartItemSeeder::class,
        WishlistItemSeeder::class,
        CouponSeeder::class,
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ...$this->mustSeed,
            ...(app()->isLocal() ? $this->testSeed : []),
        ]);
    }
}
