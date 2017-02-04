<?php

namespace App\Adapters;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class Twitter
{
    protected $client;

    public function __construct()
    {
        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key'    => config('services.twitter.client_id'),
            'consumer_secret' => config('services.twitter.client_secret'),
            'token'           => session()->get('token'),
            'token_secret'    => session()->get('tokenSecret')
        ]);

        $stack->push($middleware);

        $this->client = new Client([
            'base_uri' => config('services.twitter.base_uri'),
            'handler'  => $stack,
            'auth' => 'oauth'
        ]);
    }

    public function search($query)
    {
        $response = $this->client->get('search/tweets.json', [
            'query' => ['q' => $query]
        ]);

        return json_decode($response->getBody());
    }
}
