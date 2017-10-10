<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'twitter_user_id', 'name', 'nickname', 'api_token', 'twitter_token', 'twitter_token_secret'
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

    public function addCollection(array $attributes)
    {
        $collection = Collection::make($attributes);

        return $this->collections()->save($collection);
    }

    public function updateCollection(int $collectionId, array $attributes)
    {
        $this->collections->find($collectionId)->update([
            'title' => $attributes['title'],
            'description' => $attributes['description'],
            'public' => !!$attributes['public']
        ]);
    }

    public function removeCollection(int $collectionId)
    {
        $this->collections()->find($collectionId)->delete();
    }
}
