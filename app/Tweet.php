<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'twitter_tweet_id', 'twitter_user_id', 'user_name', 'user_nickname', 'text', 'twitter_created_at',
    ];
}
