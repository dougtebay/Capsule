<?php

namespace Tests\Unit\App\Adapters;

use Tests\TestCase;
use App\Adapters\TwitterAdapter;
use App\Repositories\TweetRepository;

class TwitterAdapterTest extends TestCase
{
    protected $twitterAdapter;

    protected function setUp()
    {
        parent::setUp();

        session()->put('token', config('services.twitter.token'));
        session()->put('tokenSecret', config('services.twitter.token_secret'));

        $this->twitterAdapter = new TwitterAdapter(new TweetRepository);
    }

    public function testItCanReturnSearchResults()
    {
        $results = $this->twitterAdapter->search('test');

        $this->assertFalse(empty($results));
    }

    public function testItCanReturnMoreSearchResultsByMaxId()
    {
        $results1 = $this->twitterAdapter->search('test');
        $maxId = $results1->last()->twitter_tweet_id;

        $results2 = $this->twitterAdapter->search('test', $maxId);
        $id = $results2->first()->twitter_tweet_id;

        $this->assertEquals($maxId, $id);
    }
}
