<?php

namespace App\SocialNetworks;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class Twitter
{
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
            'token'           => config('services.twitter.token'),
            'token_secret'    => config('services.twitter.token_secret')
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
}
