<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->baseUrl = '/api/v1/';
        $this->post = create('App\Post');
        $this->comment = create('App\Comment');
    }

    /** @test */
    public function unauthenticated_user_cannot_favorite_any_post()
    {
        $post = create('App\Post');
        $this->postJson($this->baseUrl . 'posts/' . $post->id . '/favorite')
            ->assertStatus(401);
        $this->assertDatabaseCount('favorites', 0);
    }

    /** @test */
    public function authenticated_user_can_favorite_any_post()
    {
        $post = create('App\Post');
        $this->signIn();
        $this->postJson($this->baseUrl . 'posts/' . $post->id . '/favorite')
            ->assertStatus(200);
        $this->assertDatabaseCount('favorites', 1);
    }

    /** @test */
    public function unauthenticated_user_cannot_favorite_any_comment()
    {
        $comment = create('App\Comment');
        $this->postJson($this->baseUrl . 'comments/' . $comment->id . '/favorite')
            ->assertStatus(401);
        $this->assertDatabaseCount('favorites', 0);
    }

    /** @test */
    public function authenticated_user_can_favorite_any_comment()
    {
        $comment = create('App\Comment');
        $this->signIn();
        $this->postJson($this->baseUrl . 'comments/' . $comment->id . '/favorite')
            ->assertStatus(200);
        $this->assertDatabaseCount('favorites', 1);
    }

    /** @test */
    public function authenticated_user_can_unfavorite_a_favorited_post()
    {
        $post = create('App\Post');
        $this->signIn();
        $this->postJson($this->baseUrl . 'posts/' . $post->id . '/favorite')
            ->assertStatus(200);
        $this->assertDatabaseCount('favorites', 1);
        $this->postJson($this->baseUrl . 'posts/' . $post->id . '/un_favorite')
            ->assertStatus(200);
        $this->assertDatabaseCount('favorites', 0);
    }

    /** @test */
    public function authenticated_user_can_unfavorite_a_favorited_comment()
    {
        $comment = create('App\Comment');
        $this->signIn();
        $this->postJson($this->baseUrl . 'comments/' . $comment->id . '/favorite')
        ->assertStatus(200);
        $this->assertDatabaseCount('favorites', 1);
        $this->postJson($this->baseUrl . 'comments/' . $comment->id . '/un_favorite')
        ->assertStatus(200);
        $this->assertDatabaseCount('favorites', 0);
    }

    /** @test */
    public function a_notification_is_sent_only_once_when_a_post_is_favorited()
    {
        $post = create('App\Post');
        $this->assertCount(0, $post->user->notifications);
        $this->signIn();
        $this->postJson($this->baseUrl . 'posts/' . $post->id . '/favorite');
        $this->assertCount(1, $post->user->fresh()->notifications);
        $this->postJson($this->baseUrl . 'posts/' . $post->id . '/favorite');
        $this->assertCount(1, $post->user->fresh()->notifications);
    }

    /** @test */
    public function a_notification_is_sent_only_once_when_a_comment_is_favorited()
    {
        $comment = create('App\Comment');
        $this->assertCount(0, $comment->user->notifications);
        $this->signIn();
        $this->postJson($this->baseUrl . 'comments/' . $comment->id . '/favorite');
        $this->assertCount(1, $comment->user->fresh()->notifications);
        $this->postJson($this->baseUrl . 'comments/' . $comment->id . '/favorite');
        $this->assertCount(1, $comment->user->fresh()->notifications);
    }
}
