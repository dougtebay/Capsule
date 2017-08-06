<?php

namespace App\Repositories;

use App\User;
use Laravel\Socialite\One\User as TwitterUser;

class Users
{
    public function updateOrCreate(TwitterUser $twitterUser)
    {
        if ($user = $this->findByTwitterUserId($twitterUser->user['id_str'])) {
            $user->update([
                'name' => $twitterUser->name,
                'nickname' => $twitterUser->nickname,
                'twitter_token' => $twitterUser->token,
                'twitter_token_secret' => $twitterUser->tokenSecret
            ]);

            return $user;
        }

        return User::create([
            'twitter_user_id' => $twitterUser->user['id_str'],
            'name' => $twitterUser->name,
            'nickname' => $twitterUser->nickname,
            'twitter_token' => $twitterUser->token,
            'twitter_token_secret' => $twitterUser->tokenSecret,
            'api_token' => str_random(60)
        ]);
    }

    protected function findByTwitterUserId(int $id)
    {
        return User::where('twitter_user_id', $id)->first();
    }
}
