<?php

namespace Tests\Feature\Seeding;

use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleSeederTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_role_seeding(): void
    {

        $this->seed(RoleSeeder::class);

        $this->assertDatabaseCount('roles', 5);

    }
}
