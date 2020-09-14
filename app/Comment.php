<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Favorable;

    protected $guarded = [];
    protected $appends = ['favoriteCount', 'isFavorited'];
    protected $with = ['post'];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value) {
        return (new Carbon($value))->diffForHumans();
    }

}
