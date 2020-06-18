<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Favorable;
    protected $appends = ['favoriteCount', 'isFavorited'];
    protected $casts = ['isFavorited' => 'boolean'];

    protected $guarded = [];

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
