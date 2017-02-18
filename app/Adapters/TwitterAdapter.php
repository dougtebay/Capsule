<?php

namespace App\Adapters;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use App\Repositories\TweetRepository;
use Illuminate\Session\SessionManager;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TwitterAdapter
{
    /**
     * The tweet repository instance.
     *
     * @var \App\Repositories\TweetRepository
     */
    protected $tweetRepository;

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
    public function __construct(TweetRepository $tweetRepository, SessionManager $session)
    {
        $this->tweetRepository = $tweetRepository;
        $stack = HandlerStack::create();
        $middleware = $this->getMiddleware($session);
        $stack->push($middleware);
        $this->client = $this->getClient($stack);
    }

    /**
     * Create a middleware instance.
     *
     * @return \GuzzleHttp\Subscriber\Oauth\Oauth1
     */
    public function getMiddleware(SessionManager $session)
    {
        return new Oauth1([
            'consumer_key'    => config('services.twitter.client_id'),
            'consumer_secret' => config('services.twitter.client_secret'),
            'token'           => $session->get('token'),
            'token_secret'    => $session->get('tokenSecret')
        ]);
    }

    /**
     * Create a client instance.
     *
     * @param  \GuzzleHttp\HandlerStack  $stack
     * @return \GuzzleHttp\Client
     */
    public function getClient(HandlerStack $stack)
    {
        return new Client([
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
     * @return \Illuminate\Support\Collection
     */
    public function search(string $query, string $maxId = null)
    {
        $response = $this->client->get('search/tweets.json', [
            'query' => ['q' => $query, 'max_id' => $maxId]
        ]);

        $tweets = collect(json_decode($response->getBody())->statuses);

        return $this->tweetRepository->make($tweets);
    }
}
