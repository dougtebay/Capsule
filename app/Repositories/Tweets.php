<?php

namespace App\Repositories;

use App\Tweet;

class Tweets
{
	public function findOrCreate($data)
	{
		if ($tweet = $this->findByTwitterTweetId($data['id_str'])) {
			return $tweet;
		};

		$tweet = Tweet::tweet($data);

        return $this->addTweet($tweet);
	}

	protected function findByTwitterTweetId($id)
	{
		return Tweet::where('twitter_tweet_id', $id)->first();
	}

	protected function addTweet($tweet)
	{
		$tweet->save();

		return $tweet;
	}
}
