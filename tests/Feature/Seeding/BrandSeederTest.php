<?php

namespace Tests\Feature\Seeding;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandSeederTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_brand_seed(): void
    {
        $this->seed(\Database\Seeders\BrandSeeder::class);

        $this->assertDatabaseCount('brands', 1);
    }
}
