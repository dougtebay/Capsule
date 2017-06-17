<?php

namespace App;

use App\Repositories\Tweets;
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

    public function addTweet(array $data)
    {
        if ($tweet = app(Tweets::class)->findByTwitterTweetId($data['id_str'])) {
            if (!$this->tweets->contains($tweet)) {
                $this->tweets()->attach($tweet);
                return;
            }
        }

        if (!$this->tweets->contains($tweet)) {
            $tweet = Tweet::tweet($data);

            $this->tweets()->save($tweet);
        }
    }

    public function removeTweet(Tweet $tweet)
    {
        $this->tweets()->detach($tweet);
    }
}
