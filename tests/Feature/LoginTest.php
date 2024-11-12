<?php

namespace Tests\Feature;

use Database\Seeders\AuthTestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AuthTestSeeder::class);
    }
    /**
     * A basic feature test example.
     */
    public function test_an_existing_user_can_login(): void
    {
        $this->withoutExceptionHandling();
        #teniendo
        $credentials = [
            "email" => "test@test.com",
            "password" => "password123"
        ];

        #haciendo
        $response = $this->post('/api/v1/auth/login', $credentials);
        #esperando
        $response->assertStatus(200);
        $response->assertJsonStructure(["data" => ["access_token"]]);
    }
    public function test_a_non_active_user_cannot_login(): void
    {
        $this->withoutExceptionHandling();
        #teniendo
        $credentials = [
            "email" => "test_inactive@test.com",
            "password" => "password123"
        ];

        #haciendo
        $response = $this->post('/api/v1/auth/login', $credentials);
        #esperando
        $response->assertStatus(401);
    }
    public function test_a_non_existing_user_cannot_login(): void
    {
        // Dado que
        $credentials = [
            "email" => "prueba@prueba.com",
            "password" => "password"
        ];

        // Cuando
        $response = $this->post('/api/v1/auth/login', $credentials);

        // Entonces
        $response->assertStatus(401);
    }
}
