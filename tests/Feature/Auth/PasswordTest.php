<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_password()
    {
        // Create a user to test with
        $user = User::factory()->create();

        // Test successful password creation
        $response = $this->actingAs($user)->postJson('/api/auth/password/create', [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertStatus(200);
    }

    public function test_update_password()
    {
        // Create a user to test with
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        // Test successful password update
        $response = $this->actingAs($user)->postJson('/api/auth/password/update', [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertStatus(200);
    }

    public function test_forget_password()
    {
        // Create a user to test with
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        // Test successful password reset request
        $response = $this->postJson('/api/auth/password/forget', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(200);
    }

    public function test_reset_password()
    {
        // Create a user to test with
        $user = User::factory()->create([
            'password_reset_token' => $token = Str::random(64),
        ]);

        // Test successful password reset
        $response = $this->postJson('/api/auth/password/reset', [
            'token' => $token,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertStatus(200);
    }
}
