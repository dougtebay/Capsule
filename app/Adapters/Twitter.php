<?php

namespace App\Adapters;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class Twitter
{
    /**
     * The client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Create a new twitter adapter.
     *
     * @return void
     */
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

    /**
     * Submit the search request and return the response.
     *
     * @param  string  $query
     * @param  string  $maxId
     * @return \stdClass
     */
    public function search(string $query, string $maxId = null)
    {
        $response = $this->client->get('search/tweets.json', [
            'query' => ['q' => $query, 'max_id' => $maxId]
        ]);

        return json_decode($response->getBody());
    }
}
