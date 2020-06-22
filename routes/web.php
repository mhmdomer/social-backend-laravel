<?php

use App\Category;
use App\Post;
use Illuminate\Support\Facades\Route;

Route::get('/login', function() {
    return response(['message' => 'Please login first'], 403);
})->name('login');
Route::post('/posts', 'Api\PostsController@store')->name('store');
Route::delete('/posts/{post}', 'Api\PostsController@destroy')->name('destroy');
Route::get('/posts/{post}', 'Api\PostsController@show')->name('posts.show');
Route::put('/posts/{post}', 'Api\PostsController@update')->name('posts.update');
Route::get('/users', 'Api\ProfilesController@index');
Route::get('/users/{user}', 'Api\ProfilesController@edit')->name('users.edit');
Route::put('/users/{user}', 'Api\ProfilesController@update')->name('users.update');

Route::get('/', function () {
    $categories = Category::all();
    $posts = Post::all();
    return view('welcome')->with(['categories' => $categories, 'posts' => $posts]);
})->name('welcome');
