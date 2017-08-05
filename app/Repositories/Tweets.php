<?php

namespace App\Repositories;

use App\Tweet;

class Tweets
{
	public function findOrCreate(array $tweetParams)
	{
		if ($tweet = $this->findByTwitterTweetId($tweetParams['id_str'])) {
			return $tweet;
		};

		$tweet = Tweet::tweet($tweetParams);

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
