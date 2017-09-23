<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tweets()
    {
        return $this->belongsToMany(Tweet::class, 'collection_tweet');
    }

    public static function make(array $attributes)
    {
        return new static([
            'title' => $attributes['title'],
            'description' => $attributes['description'],
            'public' => !!$attributes['public']
        ]);
    }

    public function addTweet(Tweet $tweet)
    {
        if (!$this->tweets->contains($tweet)) {
            return $this->tweets()->attach($tweet);
        }
    }

    public function removeTweet(Tweet $tweet)
    {
        return $this->tweets()->detach($tweet);
    }
}
