<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->baseUrl = '/api/v1/';
    }

    /** @test */
    public function authenticated_users_can_get_their_notifications()
    {
        $this->signIn();
        $this->getJson($this->baseUrl . 'notifications')
            ->assertStatus(200);
    }

    /** @test */
    public function authenticated_users_can_mark_their_notifications_as_read() {
        $this->signIn();
        $this->postJson($this->baseUrl . 'notifications/mark_read')
            ->assertStatus(200);
    }

}
