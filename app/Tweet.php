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
			'twitter_tweet_id' => $tweet['id_str'],
            'twitter_user_id' => $tweet['user']['id_str'],
            'user_name' => $tweet['user']['name'],
            'user_nickname' => $tweet['user']['screen_name'],
            'text' => $tweet['text'],
            'twitter_created_at' => Carbon::parse($tweet['created_at'])
	    ]);
	}
}
