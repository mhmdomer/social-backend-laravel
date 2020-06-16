<?php

namespace App;

trait Favorable
{

    protected static function bootFavorable() {
        static::deleting(function($model) {
            $model->favorites()->delete();
        });
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        if (!$this->isFavorited()) {
            $this->favorites()->create(['user_id' => auth()->id()]);
            return true;
        }
        return false;
    }

    public function unFavorite()
    {
        if ($this->isFavorited()) {
            return $this->favorites()->get()->each->delete();
        }
    }

    public function isFavorited()
    {
        return $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoriteCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->favorites->where('user_id', auth()->id())->count();
    }
}
