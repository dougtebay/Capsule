<?php

namespace App\Repositories;

use App\User;
use Laravel\Socialite\One\User as TwitterUser;

class UserRepository
{
    public function findOrCreate(TwitterUser $twitterUser)
    {
        if ($user = User::where('twitter_id', $twitterUser->id)->first()) {
            return $user;
        }

        return User::create([
            'twitter_id' => $twitterUser->id,
            'name' => $twitterUser->name,
            'nickname' => $twitterUser->nickname,
        ]);
    }
}
