<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->post = create('App\Post');
        $this->commentsUrl = '/api/v1/posts/' . $this->post->id . '/comments/';
        $this->commentUrl = '/api/v1/comments/';
    }

    /** @test */
    public function unauthenticated_users_cannot_view_comments()
    {
        $this->get($this->commentsUrl)->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_view_all_comments()
    {
        $this->signIn();
        $this->get($this->commentsUrl)->assertStatus(200);
    }

    /** @test */
    public function unauthenticated_users_cannot_create_comments()
    {
        $comment= make('App\Comment');
        $this->postJson($this->commentsUrl, $comment->toArray())->assertStatus(401);
    }

    /** @test */
    public function authenticated_users_can_create_comments()
    {
        $this->signIn();
        $comment= make('App\Comment');
        $this->postJson($this->commentsUrl, $comment->toArray())->assertStatus(200);
    }

    /** @test */
    public function unauthorized_users_cannot_edit_any_comment()
    {
        $comment= create('App\Comment');
        $this->putJson($this->commentUrl . $comment->id, make('App\Comment')->toArray())->assertStatus(401);
        $this->signIn();
        $this->putJson($this->commentUrl . $comment->id, make('App\Comment')->toArray())->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_edit_their_comments()
    {
        $this->signIn();
        $comment= create('App\Comment', ['user_id' => auth()->id()]);
        $this->putJson($this->commentUrl . $comment->id, make('App\Comment')->toArray())->assertStatus(200);
    }

    /** @test */
    public function unauthorized_users_cannot_delete_others_comments()
    {
        $comment= create('App\Comment');
        $this->deleteJson($this->commentUrl . $comment->id)->assertStatus(401);
        $this->signIn();
        $this->deleteJson($this->commentUrl . $comment->id)->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_their_comments()
    {
        $this->signIn();
        $comment= create('App\Comment', ['user_id' => auth()->id()]);
        $this->deleteJson($this->commentUrl . $comment->id)->assertStatus(200);
    }
}
