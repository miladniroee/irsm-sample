<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginWithPasswordTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_login_with_password()
    {
        // Create a user to test with
        $user = User::factory()->create([
            'phone' => '12345678901',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Test successful login
        $response = $this->postJson('/api/auth/login', [
            'phone' => '12345678901',
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        // Test login with wrong password
        $response = $this->postJson('/api/auth/login', [
            'phone' => '12345678901',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
    }
}
