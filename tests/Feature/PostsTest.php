<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function unauthorized_users_cannot_view_posts() {
        $this->get('/api/v1/posts')->assertRedirect('/login');
    }

    /** @test */
    public function registered_users_can_view_all_posts()
    {
        $this->signIn();
        $this->get('/api/v1/posts')->assertStatus(200);
    }

    /** @test */
    public function unauthorized_users_cannot_create_a_specific_post() {
        $post = make('App\Post');
        $this->postJson('/api/v1/posts', $post->toArray())->assertStatus(401);
    }

    /** @test */
    public function authorized_users_can_create_a_specific_post() {
        $this->signIn();
        $post = make('App\Post');
        $this->postJson('/api/v1/posts', $post->toArray())->assertStatus(200);
    }

    /** @test */
    public function unauthorized_users_cannot_view_a_specific_post() {
        $post = create('App\Post');
        $this->getJson('/api/v1/posts/' . $post->id)->assertStatus(401);
    }

    /** @test */
    public function authorized_users_can_view_a_specific_post() {
        $this->signIn();
        $post = create('App\Post');
        $this->getJson('/api/v1/posts/' . $post->id)->assertStatus(200);
    }

    /** @test */
    public function unauthorized_users_cannot_edit_any_post() {
        $post = create('App\Post');
        $this->putJson('/api/v1/posts/' . $post->id, make('App\Post')->toArray())->assertStatus(401);
        $this->signIn();
        $this->putJson('/api/v1/posts/' . $post->id, make('App\Post')->toArray())->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_edit_their_posts() {
        $this->signIn();
        $post = create('App\Post', ['user_id' => auth()->id()]);
        $this->putJson('/api/v1/posts/' . $post->id, make('App\Post')->toArray())->assertStatus(200);
    }

    /** @test */
    public function unauthorized_users_cannot_delete_others_posts() {
        $post = create('App\Post');
        $this->deleteJson('/api/v1/posts/' . $post->id)->assertStatus(401);
        $this->signIn();
        $this->deleteJson('/api/v1/posts/' . $post->id)->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_their_posts() {
        $this->signIn();
        $post = create('App\Post', ['user_id' => auth()->id()]);
        $this->deleteJson('/api/v1/posts/' . $post->id)->assertStatus(200);
    }

}
