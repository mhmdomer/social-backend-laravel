<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowersTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->baseUrl = '/api/v1/';
        $this->user = create('App\User');
    }

    /** @test */
    public function unauthenticated_users_cannot_follow_others()
    {
        $this->postJson($this->baseUrl . 'follow/' . $this->user->id)
            ->assertStatus(401);
        $this->assertDatabaseCount('followers', 0);
    }

    /** @test */
    public function authenticated_users_can_follow_others()
    {
        $this->signIn();
        $this->postJson($this->baseUrl . 'follow/' . $this->user->id)
            ->assertStatus(200);
        $this->assertEquals($this->user->followers()->count(), 1);
        $this->assertDatabaseCount('followers', 1);
    }

    /** @test */
    public function authenticated_users_can_unfollow_others()
    {
        $this->signIn();
        $this->postJson($this->baseUrl . 'follow/' . $this->user->id)
            ->assertStatus(200);
        $this->assertDatabaseCount('followers', 1);
        $this->assertEquals($this->user->followers()->count(), 1);
        $this->postJson($this->baseUrl . 'un_follow/' . $this->user->id)
            ->assertStatus(200);
        $this->assertEquals($this->user->followers()->count(), 0);
        $this->assertDatabaseCount('followers', 0);
    }

    /** @test */
    public function a_notification_is_sent_only_once_when_a_user_follows_another_user()
    {
        $this->signIn();
        $this->postJson($this->baseUrl . 'follow/' . $this->user->id);
        $this->assertCount(1, $this->user->fresh()->notifications);
        $this->postJson($this->baseUrl . 'follow/' . $this->user->id);
        $this->assertCount(1, $this->user->fresh()->notifications);
    }
}
