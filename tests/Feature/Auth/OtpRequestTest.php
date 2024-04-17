<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OtpRequestTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_otp_request_new_user(): void
    {
        $response = $this->postJson('/api/auth/otp', [
            'phone' => '09123456789',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status',
            'data' => [
                'token'
            ],
        ]);
    }

    public function test_otp_request_existing_user(): void
    {
        $this->postJson('/api/auth/otp', [
            'phone' => '09123456789',
        ]);

        $response = $this->postJson('/api/auth/otp', [
            'phone' => '09123456789',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status',
            'data' => [
                'token'
            ],
        ]);
    }
}
