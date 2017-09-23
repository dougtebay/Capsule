<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $guarded = [];

    public static function make(array $attributes)
	{
		return new static([
			'twitter_tweet_id' => $attributes['id_str'],
            'twitter_user_id' => $attributes['user']['id_str'],
            'user_name' => $attributes['user']['name'],
            'user_nickname' => $attributes['user']['screen_name'],
            'text' => $attributes['text'],
            'twitter_created_at' => Carbon::parse($attributes['created_at'])
	    ]);
	}
}
