<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CollectionTweetRepository
{
    public function create(string $collectionId, string $tweetId)
    {
        return DB::table('collection_tweet')->insert([
            'collection_id' => $collectionId,
            'tweet_id' => $tweetId
        ]);
    }
}
