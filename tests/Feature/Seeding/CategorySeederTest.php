<?php

namespace Tests\Feature\Seeding;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategorySeederTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_category_seed(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);

        $this->assertDatabaseCount('categories', 2);
    }
}
