<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class SearchTweetsText extends TestCase
{
    use withoutMiddleware;

    protected function setUp()
    {
        parent::setUp();

        session()->put('token', config('services.twitter.token'));
        session()->put('tokenSecret', config('services.twitter.token_secret'));
    }

    public function testItCanGetSearchResults()
    {
        $response = $this->call('GET', 'search', ['query' => 'test']);

        $response->assertStatus(200)
            ->assertViewHas('query')
            ->assertViewHas('results');
    }
}
