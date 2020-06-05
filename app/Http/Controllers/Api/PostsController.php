<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use \Cloudder;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(10);
        return response(['date' => $posts, 'message' => 'success'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'integer|required|exists:categories,id',
            'body' => 'required_without:image',
            'image' => 'required_without:body',
        ]);
        $post = new Post();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $realPath = $image->getRealPath();
            $public_id = 'posts/' . $image->getBasename() . time();
            Cloudder::upload($realPath, 'posts/' . $image->getBasename() . time());
            list($width, $height) = getimagesize($realPath);
            $imageUrl = Cloudder::show(Cloudder::getPublicId(), ['width' => $width / 2, 'height' => $height / 2]);
            $post->image = $imageUrl;
            $post->public_id = $public_id;
        }
        $post->user_id = 1;
        $post->category_id = $request->category;
        $post->body = $request->body;
        $post->save();
        return response(['data' => $post, 'message' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit')->with(['post' => $post, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $request->validate([
            'category' => 'integer|required|exists:categories,id',
            'body' => 'required_without:image',
            'image' => 'required_without:body',
        ]);
        if ($request->hasFile('image')) {
            $oldImage = $post->public_id;
            $image = $request->file('image');
            $realPath = $image->getRealPath();
            $public_id = 'posts/' . $image->getBasename() . time();
            Cloudder::upload($realPath, 'posts/' . $image->getBasename() . time());
            list($width, $height) = getimagesize($realPath);
            $imageUrl = Cloudder::show(Cloudder::getPublicId(), ['width' => $width / 2, 'height' => $height / 2]);
            $post->image = $imageUrl;
            $post->public_id = $public_id;
            if($oldImage != null) {
                Cloudder::destroyImage($oldImage);
            }
        }
        $post->category_id = $request->category;
        $post->body = $request->body;
        $post->save();
        return response(['date' => $post, 'message' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        if($post->public_id) {
            Cloudder::destroyImage($post->public_id);
        }
        $post->delete();
        return response(['data' => null, 'message' => 'success'], 200);
    }
}
