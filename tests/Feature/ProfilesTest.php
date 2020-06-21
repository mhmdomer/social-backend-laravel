<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProfilesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->baseUrl = '/api/v1/';
        $this->user = create('App\User');
    }

    /** @test */
    public function authenticated_users_can_view_any_user()
    {
        $this->signIn();
        $response = $this->getJson($this->baseUrl . 'users/' . $this->user->id);
        $response->assertStatus(200);
        $this->assertEquals($response['data']['id'], $this->user->id);
    }

    /** @test */
    public function authenticated_users_can_view_their_profile()
    {
        $this->signIn();
        $response = $this->getJson($this->baseUrl . 'profile');
        $response->assertStatus(200);
        $this->assertEquals($response['data'], auth()->user()->toArray());
    }

    /** @test */
    public function authenticated_users_can_update_their_name()
    {
        $this->signIn();
        $response = $this->postJson($this->baseUrl . 'profile', [
            'name' => 'testing',
        ]);
        $response->assertStatus(200);
        $this->assertEquals(auth()->user()->name, 'testing');
    }

}
