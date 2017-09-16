<?php

namespace Tests\Feature;

use Faker;
use App\User;
use App\Tweet;
use App\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CollectionTweetsTest extends TestCase
{
    use DatabaseMigrations;

    public function SetUp()
    {
        parent::SetUp();

        $this->user = factory(User::class)->create();

        factory(Collection::class)->create(['user_id' => $this->user->id]);
        $this->collection = $this->user->collections->first();

        factory(Tweet::class, 2)->create()->each(function ($tweet) {
            return $this->collection->tweets()->attach($tweet);
        });

        $this->tweet1 = $this->collection->tweets->first();
        $this->tweet2 = $this->collection->tweets->last();

        $this->actingAs($this->user, 'api');
    }

    public function test_can_create_collection_tweet()
    {
        $id = (string) Faker\Factory::create()->unique()->randomNumber;
        $userId = (string) Faker\Factory::create()->unique()->randomNumber;
        $name = Faker\Factory::create()->name;
        $screenName = Faker\Factory::create()->userName;
        $text = Faker\Factory::create()->text(140);
        $createdAt = date('Y-m-d H:i:s');

        $response = $this->json('POST', "api/collections/{$this->collection->id}/tweets", [
            'id_str' => $id,
            'user' => [
                'id_str' => $userId,
                'name' => $name,
                'screen_name' => $screenName
            ],
            'text' => $text,
            'created_at' => $createdAt
        ]);

        $tweet = $this->collection->fresh()->tweets->last();

        $response->assertStatus(200);
        $this->assertEquals($id, $tweet->twitter_tweet_id);
        $this->assertEquals($userId, $tweet->twitter_user_id);
        $this->assertEquals($name, $tweet->user_name);
        $this->assertEquals($screenName, $tweet->user_nickname);
        $this->assertEquals($text, $tweet->text);
        $this->assertEquals($createdAt, $tweet->twitter_created_at);
    }

    public function test_cannot_create_collection_tweet_without_id()
    {
        $response = $this->json('POST', "api/collections/{$this->collection->id}/tweets", [
            'id_str' => '',
            'user' => [
                'id_str' => (string) Faker\Factory::create()->unique()->randomNumber,
                'name' => Faker\Factory::create()->name,
                'screen_name' => Faker\Factory::create()->userName
            ],
            'text' => Faker\Factory::create()->text(140),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $response->assertStatus(422);
    }

    public function test_cannot_create_collection_tweet_without_user_id()
    {
        $response = $this->json('POST', "api/collections/{$this->collection->id}/tweets", [
            'id_str' => Faker\Factory::create()->unique()->randomNumber,
            'user' => [
                'id_str' => '',
                'name' => Faker\Factory::create()->name,
                'screen_name' => Faker\Factory::create()->userName
            ],
            'text' => Faker\Factory::create()->text(140),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $response->assertStatus(422);
    }

    public function test_cannot_create_collection_tweet_without_name()
    {
        $response = $this->json('POST', "api/collections/{$this->collection->id}/tweets", [
            'id_str' => (string) Faker\Factory::create()->unique()->randomNumber,
            'user' => [
                'id_str' => (string) Faker\Factory::create()->unique()->randomNumber,
                'name' => '',
                'screen_name' => Faker\Factory::create()->userName
            ],
            'text' => Faker\Factory::create()->text(140),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $response->assertStatus(422);
    }

    public function test_cannot_create_collection_tweet_without_screen_name()
    {
        $response = $this->json('POST', "api/collections/{$this->collection->id}/tweets", [
            'id_str' => Faker\Factory::create()->unique()->randomNumber,
            'user' => [
                'id_str' => Faker\Factory::create()->unique()->randomNumber,
                'name' => Faker\Factory::create()->name,
                'screen_name' => ''
            ],
            'text' => Faker\Factory::create()->text(140),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $response->assertStatus(422);
    }

    public function test_cannot_create_collection_tweet_without_text()
    {
        $response = $this->json('POST', "api/collections/{$this->collection->id}/tweets", [
            'id_str' => Faker\Factory::create()->unique()->randomNumber,
            'user' => [
                'id_str' => Faker\Factory::create()->unique()->randomNumber,
                'name' => Faker\Factory::create()->name,
                'screen_name' => Faker\Factory::create()->userName
            ],
            'text' => '',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $response->assertStatus(422);
    }

    public function test_cannot_create_collection_tweet_without_created_at_date()
    {
        $response = $this->json('POST', "api/collections/{$this->collection->id}/tweets", [
            'id_str' => Faker\Factory::create()->unique()->randomNumber,
            'user' => [
                'id_str' => Faker\Factory::create()->unique()->randomNumber,
                'name' => Faker\Factory::create()->name,
                'screen_name' => Faker\Factory::create()->userName
            ],
            'text' => Faker\Factory::create()->text(140),
            'created_at' => ''
        ]);

        $response->assertStatus(422);
    }

    public function test_can_destroy_collection_tweet()
    {
        $response = $this->json(
            'DELETE',
            "api/collections/{$this->collection->id}/tweets/{$this->tweet1->id}"
        );

        $tweets = $this->collection->fresh()->tweets;

        $response->assertStatus(200);
        $this->assertEquals(1, $tweets->count());
        $this->assertEquals($this->tweet2->text, $tweets->first()->text);
    }
}
