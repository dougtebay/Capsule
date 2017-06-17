<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $guarded = [];

    public static function tweet(array $data)
	{
		return new static([
			'twitter_tweet_id' => $data['id_str'],
            'twitter_user_id' => $data['user']['id_str'],
            'user_name' => $data['user']['name'],
            'user_nickname' => $data['user']['screen_name'],
            'text' => $data['text'],
            'twitter_created_at' => Carbon::parse($data['created_at'])
	    ]);
	}
}
