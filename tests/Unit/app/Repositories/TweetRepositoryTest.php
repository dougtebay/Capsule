<?php

namespace Tests\Unit\App\Repositories;

use Faker;
use stdClass;
use Tests\TestCase;
use App\Repositories\TweetRepository;

class TweetRepositoryTest extends TestCase
{
    protected $faker;
    protected $twitterRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->faker = Faker\Factory::create();
        $this->tweetRepository = new TweetRepository();
    }

    protected function getTwitterTweet()
    {
        return (object) [
            'id_str' => (string) $this->faker->unique()->randomNumber,
            'user' => (object) [
                'id_str' => (string) $this->faker->unique()->randomNumber,
                'name' => $this->faker->name,
                'screen_name' => $this->faker->userName
            ],
            'text' => $this->faker->text(140),
            'created_at' => date('D M d H:i:s O Y')
        ];
    }

    protected function getTwitterTweets(int $number)
    {
        return collect(range(1, $number))->map(function () {
            return $this->getTwitterTweet();
        });
    }

    public function testItCanMakeTweets()
    {
        $twitterTweets = $this->getTwitterTweets(5);
        $twitterTweet = $twitterTweets->first();

        $tweets = $this->tweetRepository->make($twitterTweets);
        $tweet = $tweets->first();

        $this->assertEquals($twitterTweets->count(), $tweets->count());
        $this->assertEquals($twitterTweet->id_str, $tweet->twitter_tweet_id);
        $this->assertEquals($twitterTweet->user->id_str, $tweet->twitter_user_id);
        $this->assertEquals($twitterTweet->user->name, $tweet->user_name);
        $this->assertEquals($twitterTweet->user->screen_name, $tweet->user_nickname);
        $this->assertEquals($twitterTweet->text, $tweet->text);
        $this->assertEquals($twitterTweet->created_at, $tweet->twitter_created_at);
    }
}
