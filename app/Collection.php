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

    public static function collect(array $collection)
    {
    	return new static([
    		'title' => $collection['title'],
            'description' => $collection['description'],
            'public' => isset($collection['public'])
    	]);
    }

    public function addTweet(array $tweet)
    {
        $this->tweets()->save(Tweet::tweet($tweet));
    }
}
