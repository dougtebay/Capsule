<?php

namespace Tests\Feature;

use Faker;
use App\User;
use App\Tweet;
use App\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCollectionsTest extends TestCase
{
	use DatabaseMigrations;

	public function setUp()
	{
		parent::setUp();

		$this->user = factory(User::class)->create();
		factory(Collection::class, 2)->create(['user_id' => $this->user->id]);
		$tweet = factory(Tweet::class)->create();
		$this->user->collections->first()->addTweet($tweet);

		$this->actingAs($this->user, 'api');
	}

	public function test_can_fetch_user_collections()
	{
		$response = $this->json('GET', "api/users/{$this->user->id}/collections");

		$response->assertStatus(200)->assertJson([
			[
				'id' => $this->user->collections->first()->id,
				'user_id' => $this->user->collections->first()->user_id,
				'title' => $this->user->collections->first()->title,
				'description' => $this->user->collections->first()->description,
				'public' => $this->user->collections->first()->public,
				'created_at' => $this->user->collections->first()->created_at->format('Y-m-d H:i:s'),
				'updated_at' => $this->user->collections->first()->updated_at->format('Y-m-d H:i:s')
			],
			[
				'id' => $this->user->collections->last()->id,
				'user_id' => $this->user->collections->last()->user_id,
				'title' => $this->user->collections->last()->title,
				'description' => $this->user->collections->last()->description,
				'public' => $this->user->collections->last()->public,
				'created_at' => $this->user->collections->last()->created_at->format('Y-m-d H:i:s'),
				'updated_at' => $this->user->collections->last()->updated_at->format('Y-m-d H:i:s')
			],
		]);
	}

	public function test_can_save_user_collection()
	{
		$response = $this->json('POST', "api/users/{$this->user->id}/collections", [
			'title' => $title = Faker\Factory::create()->unique()->text(50),
        	'description' => $description = Faker\Factory::create()->unique()->text(100),
        	'public' => '1'
		]);

		$response->assertStatus(200);
		$this->assertEquals($title, $this->user->fresh()->collections->last()->title);
		$this->assertEquals($description, $this->user->fresh()->collections->last()->description);
		$this->assertEquals(1, $this->user->fresh()->collections->last()->public);
	}

	public function test_cannot_save_user_collection_without_title()
	{
		$response = $this->json('POST', "api/users/{$this->user->id}/collections", [
			'title' => '',
        	'description' => $description = Faker\Factory::create()->unique()->text(100),
        	'public' => 'true'
		]);

		$response->assertStatus(422)->assertJsonFragment(['title']);
	}

	public function test_cannot_save_user_collection_without_public()
	{
		$response = $this->json('POST', "api/users/{$this->user->id}/collections", [
			'title' => $title = Faker\Factory::create()->unique()->text(50),
        	'description' => $description = Faker\Factory::create()->unique()->text(100),
        	'public' => ''
		]);

		$response->assertStatus(422)->assertJsonFragment(['public']);
	}

	public function test_can_fetch_user_collection()
	{
		$response = $this->json('GET', "api/users/{$this->user->id}/collections/{$this->user->collections->first()->id}");

		$response->assertStatus(200)->assertJson([
			'id' => $this->user->collections->first()->id,
			'user_id' => $this->user->collections->first()->user_id,
			'title' => $this->user->collections->first()->title,
			'description' => $this->user->collections->first()->description,
			'public' => $this->user->collections->first()->public,
			'created_at' => $this->user->collections->first()->created_at->format('Y-m-d H:i:s'),
			'updated_at' => $this->user->collections->first()->updated_at->format('Y-m-d H:i:s')
		]);
	}

	public function test_can_fetch_user_collection_with_tweets()
	{
		$collection = $this->user->collections->first()->fresh();
		$tweets = $collection->tweets;

		$response = $this->json('GET', "api/users/{$this->user->id}/collections/{$collection->id}", [
			'with-tweets' => 'true'
		]);

		$response->assertStatus(200)->assertJson([
			'id' => $collection->id,
			'user_id' => $collection->user_id,
			'title' => $collection->title,
			'description' => $collection->description,
			'public' => $collection->public,
			'created_at' => $collection->created_at->format('Y-m-d H:i:s'),
			'updated_at' => $collection->updated_at->format('Y-m-d H:i:s'),
			'tweets' => [
				[
					'id' => $tweets->first()->id,
					'twitter_tweet_id' => $tweets->first()->twitter_tweet_id,
					'twitter_user_id' => $tweets->first()->twitter_user_id,
	            	'user_name' => $tweets->first()->user_name,
	            	'user_nickname' => $tweets->first()->user_nickname,
	            	'text' => $tweets->first()->text,
	            	'twitter_created_at' => $tweets->first()->twitter_created_at,
	            	'created_at' => $tweets->first()->created_at->format('Y-m-d H:i:s'),
	            	'updated_at' => $tweets->first()->updated_at->format('Y-m-d H:i:s'),
	            	'pivot' => [
	            		'collection_id' => $collection->id,
	            		'tweet_id' => $tweets->first()->id
	            	]
				]
			]
		]);
	}
}
