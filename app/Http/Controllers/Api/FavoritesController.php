<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Notifications\YourCommentWasFavorited;
use App\Notifications\YourPostWasFavorited;
use App\Post;

class FavoritesController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Post
     */
    public function storePost(Post $post)
    {
        $favorited = $post->favorite();
        if ($favorited && auth()->id() != $post->user_id)
            $post->user->notify(new YourPostWasFavorited($post, auth()->user()));
        return response(['message' => 'success']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Comment
     */
    public function storeComment(Comment $comment)
    {
        $favorited = $comment->favorite();
        if ($favorited) $comment->user->notify(new YourCommentWasFavorited($comment, auth()->user()));
        return response(['message' => 'success']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \App\Post
     */
    public function destroyPost(Post $post)
    {
        $post->unFavorite();
        return response(['message' => 'success']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \App\Comment
     */
    public function destroyComment(Comment $comment)
    {
        $comment->unFavorite();
        return response(['message' => 'success']);
    }
}
