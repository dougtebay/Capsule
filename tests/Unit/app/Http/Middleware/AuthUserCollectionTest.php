<?php

namespace Tests\App\Http\Middleware;

use Faker;
use App\User;
use App\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthUserCollectionTest extends TestCase
 {
    use RefreshDatabase;

    protected $collection1;
    protected $collection2;

    public function SetUp()
    {
        parent::SetUp();

        $user = factory(User::class)->create();
        list($this->collection1, $this->collection2) = factory(Collection::class, 2)->create();

        $user->collections()->save($this->collection1);

        $this->actingAs($user, 'api');
    }

    public function test_it_can_access_collection_tweet_routes()
    {
        $response = $this->json('POST', "api/collections/{$this->collection1->id}/tweets", [
            'id_str' => (string) Faker\Factory::create()->unique()->randomNumber,
            'user' => [
                'id_str' => (string) Faker\Factory::create()->unique()->randomNumber,
                'name' => Faker\Factory::create()->name,
                'screen_name' => Faker\Factory::create()->userName
            ],
            'text' => Faker\Factory::create()->text(140),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $response->assertStatus(200);
    }

    public function test_it_cannot_access_collection_tweet_routes_without_authorization()
    {
        $response = $this->json('POST', "api/collections/{$this->collection2->id}/tweets", [
            'id_str' => (string) Faker\Factory::create()->unique()->randomNumber,
            'user' => [
                'id_str' => (string) Faker\Factory::create()->unique()->randomNumber,
                'name' => Faker\Factory::create()->name,
                'screen_name' => Faker\Factory::create()->userName
            ],
            'text' => Faker\Factory::create()->text(140),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $response->assertStatus(403);
    }
}
