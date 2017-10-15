<?php

namespace Tests\Feature;

use Faker;
use App\User;
use App\Tweet;
use App\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCollectionsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $collection1;
    protected $collection2;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        factory(Collection::class, 2)->create()->each(function ($collection) {
            $this->user->collections()->save($collection);
        });
        
        $this->collection1 = $this->user->collections->first();
        $this->collection2 = $this->user->collections->last();

        $tweet = factory(Tweet::class)->create();
        $this->user->collections->first()->addTweet($tweet);

        $this->actingAs($this->user, 'api');
    }

    public function test_it_can_get_user_collections()
    {
        $response = $this->json('GET', "api/users/{$this->user->id}/collections");

        $response->assertStatus(200)->assertJson([
            [
                'id' => $this->collection1->id,
                'user_id' => $this->collection1->user_id,
                'title' => $this->collection1->title,
                'description' => $this->collection1->description,
                'public' => $this->collection1->public,
                'created_at' => $this->collection1->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->collection1->updated_at->format('Y-m-d H:i:s')
            ],
            [
                'id' => $this->collection2->id,
                'user_id' => $this->collection2->user_id,
                'title' => $this->collection2->title,
                'description' => $this->collection2->description,
                'public' => $this->collection2->public,
                'created_at' => $this->collection2->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->collection2->updated_at->format('Y-m-d H:i:s')
            ]
        ]);
    }

    public function test_it_can_create_user_collection()
    {
        $title = Faker\Factory::create()->unique()->text(50);
        $description = Faker\Factory::create()->unique()->text(100);

        $response = $this->json('POST', "api/users/{$this->user->id}/collections", [
            'title' => $title,
            'description' => $description,
            'public' => '1'
        ]);

        $collection = $this->user->fresh()->collections->last();

        $response->assertStatus(200);
        $this->assertEquals($title, $collection->title);
        $this->assertEquals($description, $collection->description);
        $this->assertEquals(1, $collection->public);
    }

    public function test_it_cannot_create_user_collection_without_title()
    {
        $response = $this->json('POST', "api/users/{$this->user->id}/collections", [
            'title' => '',
            'description' => Faker\Factory::create()->text(100),
            'public' => '1'
        ]);

        $response->assertStatus(422)->assertJsonFragment(['title']);
    }

    public function test_it_cannot_create_user_collection_with_long_title()
    {
        $response = $this->json('POST', "api/users/{$this->user->id}/collections", [
            'title' => str_random(51),
            'description' => Faker\Factory::create()->text(100),
            'public' => '1'
        ]);

        $response->assertStatus(422)->assertJsonFragment(['title']);
    }

    public function test_it_cannot_create_user_collection_with_long_description()
    {
        $response = $this->json('POST', "api/users/{$this->user->id}/collections", [
            'title' => Faker\Factory::create()->text(50),
            'description' => str_random(101),
            'public' => '1'
        ]);

        $response->assertStatus(422)->assertJsonFragment(['description']);
    }

    public function test_it_cannot_create_user_collection_without_public()
    {
        $response = $this->json('POST', "api/users/{$this->user->id}/collections", [
            'title' => Faker\Factory::create()->text(50),
            'description' => Faker\Factory::create()->text(100),
            'public' => ''
        ]);

        $response->assertStatus(422)->assertJsonFragment(['public']);
    }

    public function test_it_can_update_user_collection()
    {
        $title = Faker\Factory::create()->unique()->text(50);
        $description = Faker\Factory::create()->unique()->text(100);

        $response = $this->json(
            'PUT',
            "api/users/{$this->user->id}/collections/{$this->collection1->id}", [
                'title' => $title,
                'description' => $description,
                'public' => '1'
            ]
        );

        $collection = $this->collection1->fresh();

        $response->assertStatus(200);
        $this->assertEquals($title, $collection->title);
        $this->assertEquals($description, $collection->description);
        $this->assertEquals(1, $collection->public);
    }

    public function test_it_cannot_update_user_collection_without_title()
    {
        $response = $this->json(
            'PUT',
            "api/users/{$this->user->id}/collections/{$this->user->collections->first()->id}", [
                'title' => '',
                'description' => Faker\Factory::create()->text(100),
                'public' => '1'
            ]
        );

        $response->assertStatus(422)->assertJsonFragment(['title']);
    }

    public function test_it_cannot_update_user_collection_with_long_title()
    {
        $response = $this->json(
            'PUT',
            "api/users/{$this->user->id}/collections/{$this->user->collections->first()->id}", [
                'title' => str_random(51),
                'description' => Faker\Factory::create()->text(100),
                'public' => '1'
            ]
        );

        $response->assertStatus(422)->assertJsonFragment(['title']);
    }

    public function test_it_cannot_update_user_collection_with_long_description()
    {
        $response = $this->json(
            'PUT',
            "api/users/{$this->user->id}/collections/{$this->user->collections->first()->id}", [
                'title' => Faker\Factory::create()->text(50),
                'description' => str_random(101),
                'public' => '1'
            ]
        );

        $response->assertStatus(422)->assertJsonFragment(['description']);
    }

    public function test_it_cannot_update_user_collection_without_public()
    {
        $response = $this->json(
            'PUT',
            "api/users/{$this->user->id}/collections/{$this->user->collections->first()->id}", [
                'title' => Faker\Factory::create()->text(50),
                'description' => Faker\Factory::create()->text(100),
                'public' => ''
            ]
        );

        $response->assertStatus(422)->assertJsonFragment(['public']);
    }

    public function test_it_can_destroy_user_collection()
    {
        $response = $this->json(
            'DELETE',
            "api/users/{$this->user->id}/collections/{$this->collection1->id}"
        );

        $collections = $this->user->fresh()->collections;

        $response->assertStatus(200);
        $this->assertCount(1, $collections);
        $this->assertEquals($this->collection2->title, $collections->first()->title);
    }
}
