<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Comment;
use App\Post;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Category::class, function(Faker $faker) {
    $name = $faker->name;
    return [
        'name' => $name,
        'slug' => Str::slug($name),
    ];
});

$factory->define(Post::class, function(Faker $faker) {
    return [
        'body' => $faker->paragraph,
        'category_id' => function() {
            return factory(Category::class)->create()->id;
        },
        'user_id' => function() {
            return factory(User::class)->create()->id;
        }
    ];
});

$factory->define(Comment::class, function(Faker $faker) {
    return [
        'body' => $faker->sentence,
        'post_id' => function() {
            return factory(Post::class)->create()->id;
        },
        'user_id' => function() {
            return factory(User::class)->create()->id;
        }
    ];
});
