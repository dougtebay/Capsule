<?php

namespace Tests\Unit\App\Adapters;

use Tests\TestCase;
use App\Adapters\Twitter;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TwitterTest extends TestCase
{
    protected function setUpTwitter()
    {
        session()->put('token', config('services.twitter.token'));
        session()->put('tokenSecret', config('services.twitter.token_secret'));

        return new Twitter();
    }

    public function testItCanReturnSearchResults()
    {
        $twitter = $this->setUpTwitter();

        $results = $twitter->search('test');

        $this->assertEquals(15, count($results->statuses));
    }

    public function testItCanReturnMoreSearchResultsByMaxId()
    {
        $twitter = $this->setUpTwitter();

        $results1 = $twitter->search('test');
        $maxId = collect($results1->statuses)->last()->id_str;

        $results2 = $twitter->search('test', $maxId);
        $id = collect($results2->statuses)->first()->id_str;

        $this->assertEquals($maxId, $id);
    }
}
