<?php

namespace App\Repositories;

use App\User;
use Laravel\Socialite\One\User as TwitterUser;

class Users
{
    public function findOrCreate(TwitterUser $twitterUser)
    {
        if (!$user = User::where('twitter_user_id', $twitterUser->user['id_str'])->first()) {
            return User::create([
                'twitter_user_id' => $twitterUser->user['id_str'],
                'name' => $twitterUser->name,
                'nickname' => $twitterUser->nickname,
                'twitter_token' => $twitterUser->token,
                'twitter_token_secret' => $twitterUser->tokenSecret,
                'api_token' => str_random(60)
            ]);
        }

        if ($twitterUser->token !== $user->twitter_token) {
            $user->update(['twitter_token', $twitterUser->token]);
        }

        if ($twitterUser->tokenSecret !== $user->twitter_token_secret) {
            $user->update(['twitter_token_secret', $twitterUser->tokenSecret]);
        }

        return $user;
    }
}
