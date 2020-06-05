<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::post('/register', 'Api\AuthenticationController@register');
    Route::post('/login', 'Api\AuthenticationController@login');

    Route::group(['middleware' => ['auth:api']], function () {
        //profile
        Route::get('/profile', 'Api\ProfilesController@show');
        Route::put('/profile', 'Api\ProfilesController@update');
        //posts
        Route::apiResource('posts', 'Api\PostsController');
        //comments
        Route::get('/posts/{post}/comments', 'Api\CommentsController@index');
        Route::post('/posts/{post}/comments', 'Api\CommentsController@store');
        Route::put('comments/{comment}', 'Api\CommentsController@update');
        Route::delete('comments/{comment}', 'Api\CommentsController@destroy');
        //categories
        Route::get('categories', 'Api\CategoriesController@index');
    });

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
});
