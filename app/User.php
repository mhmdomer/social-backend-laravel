<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['followerCount', 'followingCount', 'followingMe', 'followed'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id');
    }

    public function follow(User $user)
    {
        if ($this->following()->where('following_id', $user->id)->count() > 0) {
            return false;
        }
        $this->following()->attach($user->id);
        return true;
    }

    public function unFollow(User $user)
    {
        $this->following()->detach($user->id);
        return false;
    }

    public function getFollowerCountAttribute()
    {
        return $this->followers()->count();
    }

    public function getFollowingCountAttribute()
    {
        return $this->following()->count();
    }

    public function getFollowingMeAttribute()
    {
        return $this->followers()->where('follower_id', auth()->id())->count() > 0;
    }

    public function getFollowedAttribute()
    {
        return $this->following()->where('following_id', auth()->id())->count() > 0;
    }
}
