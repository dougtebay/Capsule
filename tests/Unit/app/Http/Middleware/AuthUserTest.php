<?php

namespace Tests\App\Http\Middleware;

use Faker;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthUserTest extends TestCase
 {
    use RefreshDatabase;

    protected $user1;
    protected $user2;

    public function SetUp()
    {
        parent::SetUp();

        list($this->user1, $this->user2) = factory(User::class, 2)->create();

        $this->actingAs($this->user1, 'api');
    }

    public function test_it_can_access_user_collection_routes()
    {
        $response = $this->json('GET', "api/users/{$this->user1->id}/collections");

        $response->assertStatus(200);
    }

    public function test_it_cannot_access_user_collection_routes_without_authorization()
    {
        $response = $this->json('GET', "api/users/{$this->user2->id}/collections");

        $response->assertStatus(403);
    }
}
