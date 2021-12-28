<?php

namespace Database\Seeders;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategoriesTableSeeder::class,
        ]);
        if(User::count() < 1)
        $user = User::firstOrCreate([
            'name' => 'mohammed',
            'email' => 'mohammed@gmail.com',
            'password' => bcrypt('111111')
        ]);
        $posts = factory(Post::class, 4)->create();
        foreach($posts as $post) {
            factory(Comment::class, 3)->create(['post_id' => $post->id]);
        }
    }
}
