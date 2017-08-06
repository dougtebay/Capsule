<?php

namespace App\SocialNetworks;

use App\SocialNetworks\Twitter;
use App\Contracts\SocialNetworkAdapter;

class TwitterAdapter implements SocialNetworkAdapter
{
    protected $twitter;

    public function __construct(Twitter $twitter)
    {
        $this->twitter = $twitter->client;
    }

    public function search(string $query, string $cursor)
    {
        $response = $this->twitter->get('search/tweets.json', [
            'query' => ['q' => $query, 'max_id' => $cursor]
        ]);

        return json_decode($response->getBody())->statuses;
    }
}
