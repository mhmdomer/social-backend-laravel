<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function register_requires_valid_data()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Validation\ValidationException');
        $response = $this->post('/api/register');
    }

    /** @test */
    public function user_can_register_when_he_provide_valid_data()
    {
        $this->withoutExceptionHandling();
        $this->post('/api/register', [
            'name' => 'mohammed', 'email' => 'mohammed@gmail.com', 'password' => '111111'
        ])->assertStatus(200);

    }
}
