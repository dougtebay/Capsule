<?php

namespace App\Services;

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

    protected function getMiddleware()
    {
        return new Oauth1([
            'consumer_key'    => config('services.twitter.client_id'),
            'consumer_secret' => config('services.twitter.client_secret'),
            'token'           => $this->getToken(),
            'token_secret'    => $this->getTokenSecret()
        ]);
    }

    protected function getToken()
    {
        if (!auth()->guard('api')->user()) {
            return config('services.twitter.token');
        }

        return auth()->guard('api')->user()->twitter_token;
    }

    protected function getTokenSecret()
    {
        if (!auth()->guard('api')->user()) {
            return config('services.twitter.token_secret');
        }

        return auth()->guard('api')->user()->twitter_token_secret;
    }

    protected function getClient(HandlerStack $stack)
    {
        return new Client([
            'base_uri' => config('services.twitter.base_uri'),
            'handler'  => $stack,
            'auth' => 'oauth'
        ]);
    }
}
