<?php

namespace App\Providers;

use App\Comment;
use App\Post;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => 'App\Policies\PostsPolicy',
        Comment::class => 'App\Policies\CommentsPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        // Passport::loadKeysFrom('');

        Passport::tokensExpireIn(now()->addYears(10));

        Passport::refreshTokensExpireIn(now()->addYears(10));

        Passport::personalAccessTokensExpireIn(now()->addYears(10));
    }
}
