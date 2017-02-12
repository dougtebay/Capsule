<?php

namespace Tests\Unit\App\Adapters;

use Tests\TestCase;
use App\Adapters\Twitter;
use App\Repositories\TweetRepository;

class TwitterTest extends TestCase
{
    protected $twitter;

    protected function setUp()
    {
        parent::setUp();

        session()->put('token', config('services.twitter.token'));
        session()->put('tokenSecret', config('services.twitter.token_secret'));

        $this->twitter = new Twitter(new TweetRepository);
    }

    public function testItCanReturnSearchResults()
    {
        $results = $this->twitter->search('test');

        $this->assertFalse(empty($results));
    }

    public function testItCanReturnMoreSearchResultsByMaxId()
    {
        $results1 = $this->twitter->search('test');
        $maxId = $results1->last()->twitter_tweet_id;

        $results2 = $this->twitter->search('test', $maxId);
        $id = $results2->first()->twitter_tweet_id;

        $this->assertEquals($maxId, $id);
    }
}
