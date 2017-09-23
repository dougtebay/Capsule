<?php

namespace App\Repositories;

use App\Tweet;

class Tweets
{
    public function findOrCreate(array $attributes)
    {
        if ($tweet = $this->findByTwitterTweetId($attributes['id_str'])) {
            return $tweet;
        };

        $tweet = Tweet::make($attributes);

        return $this->addTweet($tweet);
    }

    protected function findByTwitterTweetId(int $id)
    {
        return Tweet::where('twitter_tweet_id', $id)->first();
    }

    protected function addTweet(Tweet $tweet)
    {
        $tweet->save();

        return $tweet;
    }
}
