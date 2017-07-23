<?php

namespace App\Adapters;

use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TwitterAdapter
{
    protected $client;

    public function __construct(User $user)
    {
        $stack = HandlerStack::create();
        $middleware = $this->getMiddleware($user);
        $stack->push($middleware);
        $this->client = $this->getClient($stack);
    }

    public function getMiddleware(User $user)
    {
        return new Oauth1([
            'consumer_key'    => config('services.twitter.client_id'),
            'consumer_secret' => config('services.twitter.client_secret'),
            'token'           => $user->twitter_token,
            'token_secret'    => $user->twitter_token_secret
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
