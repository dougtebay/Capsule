<?php

namespace Tests\Unit;

use Faker;
use App\Tweet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TweetTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_can_make_tweet()
    {
        $id = (string) Faker\Factory::create()->unique()->randomNumber;
        $userId = (string) Faker\Factory::create()->unique()->randomNumber;
        $name = Faker\Factory::create()->name;
        $screenName = Faker\Factory::create()->userName;
        $text = Faker\Factory::create()->text(140);
        $createdAt = date('Y-m-d H:i:s');

        $tweet = Tweet::make([
            'id_str' => $id,
            'user' => [
                'id_str' => $userId,
                'name' => $name,
                'screen_name' => $screenName
            ],
            'text' => $text,
            'created_at' => $createdAt
        ]);

        $this->assertEquals($id, $tweet->twitter_tweet_id);
        $this->assertEquals($userId, $tweet->twitter_user_id);
        $this->assertEquals($name, $tweet->user_name);
        $this->assertEquals($screenName, $tweet->user_nickname);
        $this->assertEquals($text, $tweet->text);
        $this->assertEquals($createdAt, $tweet->twitter_created_at);
    }
}
