<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'twitter_user_id', 'name', 'nickname', 'api_token'
    ];

    protected $hidden = [
       'remember_token'
    ];

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    public function tweets()
    {
        return $this->hasManyThrough(Tweet::class, Collection::class);
    }

    public function addCollection(array $collection)
    {
        $this->collections()->save(Collection::collect($collection));
    }

    public function removeCollection(int $collectionId)
    {
        $this->collections()->find($collectionId)->delete();
    }
}
