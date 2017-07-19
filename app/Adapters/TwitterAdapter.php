<?php

namespace App\Adapters;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TwitterAdapter
{
    protected $client;

    public function __construct()
    {
        $stack = HandlerStack::create();
        $middleware = $this->getMiddleware();
        $stack->push($middleware);
        $this->client = $this->getClient($stack);
    }

    public function getMiddleware()
    {
        return new Oauth1([
            'consumer_key'    => config('services.twitter.client_id'),
            'consumer_secret' => config('services.twitter.client_secret'),
            'token'           => session()->get('token'),
            'token_secret'    => session()->get('tokenSecret')
        ]);
    }

    public function getClient(HandlerStack $stack)
    {
        return new Client([
            'base_uri' => config('services.twitter.base_uri'),
            'handler'  => $stack,
            'auth' => 'oauth'
        ]);
    }

    public function search(string $query, string $maxId = null)
    {
        $response = $this->client->get('search/tweets.json', [
            'query' => ['q' => $query, 'max_id' => $maxId]
        ]);

        return json_decode($response->getBody())->statuses;
    }
}
