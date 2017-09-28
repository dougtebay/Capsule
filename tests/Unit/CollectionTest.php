<?php

namespace Tests\Unit;

use Faker;
use App\Tweet;
use App\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    protected $collection;
    protected $tweet;

    public function SetUp()
    {
        parent::SetUp();

        $this->collection = factory(Collection::class)->create();
        $this->tweet = factory(Tweet::class)->create();
    }

    public function test_it_can_make_collection()
    {
        $title = Faker\Factory::create()->unique()->text(50);
        $description = Faker\Factory::create()->unique()->text(100);

        $collection = Collection::make([
            'title' => $title,
            'description' => $description,
            'public' => 1
        ]);

        $this->assertEquals($title, $collection->title);
        $this->assertEquals($description, $collection->description);
        $this->assertEquals(1, $collection->public);
    }

    public function test_it_can_add_tweet()
    {
        $this->collection->addTweet($this->tweet);

        $tweets = $this->collection->fresh()->tweets;

        $this->assertEquals($this->tweet->text, $tweets->last()->text);
    }

    public function test_it_can_remove_tweet()
    {
        $this->collection->addTweet($this->tweet);
        $this->collection->removeTweet($this->tweet);

        $this->assertCount(0, $this->collection->fresh()->tweets);
    }
}
