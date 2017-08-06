<?php

namespace Tests\Unit\App\Repositories;

use Faker;
use App\Tweet;
use Tests\TestCase;
use App\Repositories\Tweets;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TweetsTest extends TestCase
{
    use DatabaseMigrations;

    protected $tweets;

    protected function setUp()
    {
        parent::setUp();

        $this->tweets = new Tweets();
    }

    protected function tweetParams()
    {
        return [
            'id_str' => (string) Faker\Factory::create()->unique()->randomNumber,
            'user' => [
                'id_str' => (string) Faker\Factory::create()->unique()->randomNumber,
                'name' => Faker\Factory::create()->name,
                'screen_name' => Faker\Factory::create()->userName
            ],
            'text' => Faker\Factory::create()->text(140),
            'created_at' => date('D M d H:i:s O Y')
        ];
    }

    public function test_it_can_create_tweet()
    {
        $tweetParams = $this->tweetParams();

        $tweet = $this->tweets->findOrCreate($tweetParams);

        $this->assertEquals($tweetParams['id_str'], $tweet->twitter_tweet_id);
        $this->assertEquals(Tweet::first()->id, $tweet->id);
    }

    public function test_it_can_find_tweet()
    {
        $tweetParams = $this->tweetParams();

        $tweetA = $this->tweets->findOrCreate($tweetParams);
        $tweetB = $this->tweets->findOrCreate($tweetParams);

        $this->assertEquals($tweetA->id, $tweetB->id);
    }
}
