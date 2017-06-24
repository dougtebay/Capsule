<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTweetsText extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        parent::setUp();

        session()->put('token', config('services.twitter.token'));
        session()->put('tokenSecret', config('services.twitter.token_secret'));
    }

    public function testItCanGetSearchResults()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->call('GET', 'search', ['query' => 'test']);

        $response->assertStatus(200)
            ->assertViewHas('query')
            ->assertViewHas('results');
    }
}
