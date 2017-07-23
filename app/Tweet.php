<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $guarded = [];

    public static function tweet(array $tweetParams)
	{
		return new static([
			'twitter_tweet_id' => $tweetParams['id_str'],
            'twitter_user_id' => $tweetParams['user']['id_str'],
            'user_name' => $tweetParams['user']['name'],
            'user_nickname' => $tweetParams['user']['screen_name'],
            'text' => $tweetParams['text'],
            'twitter_created_at' => Carbon::parse($tweetParams['created_at'])
	    ]);
	}
}
