<?php

namespace App\Repositories;

use App\User;
use Laravel\Socialite\One\User as TwitterUser;

class UserRepository
{
    public function findOrCreate(TwitterUser $twitterUser)
    {
        $user = User::where('twitter_id', $twitterUser->id)->first();

        if (! $user) {
            return User::create([
                'twitter_id' => $twitterUser->id,
                'name' => $twitterUser->name,
                'nickname' => $twitterUser->nickname,
            ]);
        }

        return $user;
    }
}
