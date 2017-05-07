<?php

namespace App\Repositories;

use App\Tweet;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TweetRepository
{
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
