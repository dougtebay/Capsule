<?php

namespace Tests\Unit;

use Faker;
use App\User;
use App\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function SetUp()
    {
        parent::SetUp();

        $this->user = factory(User::class)->create();
    }

    protected function collectionParams()
    {
        return [
            'title' => Faker\Factory::create()->unique()->text(50),
            'description' => Faker\Factory::create()->unique()->text(100),
            'public' => '1'
        ];
    }

    public function test_it_can_add_collection()
    {
        $collectionParams = $this->collectionParams();

        $this->user->addCollection($collectionParams);

        $collection = $this->user->fresh()->collections->last();

        $this->assertEquals($collectionParams['title'], $collection->title);
    }

    public function test_it_can_remove_collection()
    {
        $this->user->addCollection($this->collectionParams());

        $collection = $this->user->collections->first();

        $this->user->removeCollection($collection->id);

        $this->assertCount(0, $this->user->fresh()->collections);
    }
}
