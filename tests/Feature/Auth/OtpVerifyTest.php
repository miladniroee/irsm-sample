<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OtpVerifyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_otp_verify(): void
    {
        $responseRequest = $this->postJson('/api/auth/otp', [
            'phone' => '09123456789',
        ]);


        $response = $this->postJson('/api/auth/otp/verify', [
            'otp' => $responseRequest->json('data.otp'),
        ],[
            'Authorization' => 'Bearer '.$responseRequest->json('data.token')
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'phone' => '09123456789',
            'phone_verified_at' => now(),
        ]);

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
