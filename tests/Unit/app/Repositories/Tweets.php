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

    protected $faker;
    protected $tweets;

    protected function setUp()
    {
        parent::setUp();

        $this->faker = Faker\Factory::create();
        $this->tweets = new Tweets();
    }

    protected function tweetParams()
    {
        return [
            'id_str' => (string) $this->faker->unique()->randomNumber,
            'user' => [
                'id_str' => (string) $this->faker->unique()->randomNumber,
                'name' => $this->faker->name,
                'screen_name' => $this->faker->userName
            ],
            'text' => $this->faker->text(140),
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
