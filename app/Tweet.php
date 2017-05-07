<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $guarded = [];

    public static function tweet(array $tweet)
	{
		return new static([
	        'twitter_tweet_id' => $tweet['twitter_tweet_id'],
	        'twitter_user_id' => $tweet['twitter_user_id'],
	        'user_name' => $tweet['user_name'],
	        'user_nickname' => $tweet['user_nickname'],
	        'text' => $tweet['text'],
	        'twitter_created_at' => Carbon::parse($tweet['twitter_created_at'])
	    ]);
	}
}
