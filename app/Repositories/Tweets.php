<?php

namespace App\Repositories;

use App\Tweet;

class Tweets
{
	public function findByTwitterTweetId($id)
	{
		return Tweet::where('twitter_tweet_id', $id)->first();
	}
}
