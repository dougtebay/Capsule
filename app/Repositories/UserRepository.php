<?php

namespace App\Repositories;

use App\User;
use Laravel\Socialite\One\User as TwitterUser;

class UserRepository
{
    /**
     * Find or create the user.
     *
     * @param  \Laravel\Socialite\One\User  $twitterUser
     * @return \App\User
     */
    public function findOrCreate(TwitterUser $twitterUser)
    {
        $user = User::where('twitter_id', $twitterUser->user['id_str'])->first();

        if (! $user) {
            return User::create([
                'twitter_id' => $twitterUser->user['id_str'],
                'name' => $twitterUser->name,
                'nickname' => $twitterUser->nickname,
            ]);
        }

        return $user;
    }
}
