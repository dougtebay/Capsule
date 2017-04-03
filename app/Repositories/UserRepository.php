<?php

namespace App\Repositories;

use App\User;
use Laravel\Socialite\One\User as TwitterUser;

class UserRepository
{
    public function findOrCreate(TwitterUser $twitterUser)
    {
        if (! $user = User::where('twitter_user_id', $twitterUser->user['id_str'])->first()) {
            return User::create([
                'twitter_user_id' => $twitterUser->user['id_str'],
                'name' => $twitterUser->name,
                'nickname' => $twitterUser->nickname,
            ]);
        }

        return $user;
    }
}
