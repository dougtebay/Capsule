<?php

namespace Tests\Unit\App\Adapters;

use Tests\TestCase;
use App\Adapters\Twitter;
use App\Repositories\TweetRepository;

class TwitterTest extends TestCase
{
    protected $tweetRepository;

    protected function getTwitter()
    {
        session()->put('token', config('services.twitter.token'));
        session()->put('tokenSecret', config('services.twitter.token_secret'));

        return new Twitter(new TweetRepository);
    }

    public function testItCanReturnSearchResults()
    {
        $twitter = $this->getTwitter();

        $results = $twitter->search('test');

        $this->assertEquals(15, $results->count());
    }

    public function testItCanReturnMoreSearchResultsByMaxId()
    {
        $twitter = $this->getTwitter();

        $results1 = $twitter->search('test');
        $maxId = $results1->last()->twitter_tweet_id;

        $results2 = $twitter->search('test', $maxId);
        $id = $results2->first()->twitter_tweet_id;

        $this->assertEquals($maxId, $id);
    }
}
