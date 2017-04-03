<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'twitter_user_id', 'name', 'nickname'
    ];

    protected $hidden = [
       'remember_token'
    ];

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}
