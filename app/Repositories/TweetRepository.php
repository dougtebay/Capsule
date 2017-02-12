<?php

namespace App\Repositories;

use App\Tweet;
use Illuminate\Support\Collection;

class TweetRepository
{
    /**
     * Make tweets.
     *
     * @param  \Illuminate\Support\Collection  $twitterTweets
     * @return \Illuminate\Support\Collection
     */
    public function make(Collection $twitterTweets)
    {
        return $twitterTweets->map(function ($twitterTweet) {
            return new Tweet([
                'twitter_tweet_id' => $twitterTweet->id_str,
                'twitter_user_id' => $twitterTweet->user->id_str,
                'user_name' => $twitterTweet->user->name,
                'user_nickname' => $twitterTweet->user->screen_name,
                'text' => $twitterTweet->text,
                'twitter_created_at' => $twitterTweet->created_at
            ]);
        });
    }
}
