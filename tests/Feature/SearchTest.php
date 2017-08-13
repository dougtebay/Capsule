<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Contracts\SocialNetworkAdapter;
use App\Services\FakeSocialNetworkAdapter;

class SearchTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        app()->instance(SocialNetworkAdapter::class, new FakeSocialNetworkAdapter);
    }

    public function test_can_fetch_search_results()
    {
        $response = $this->json('GET', 'api/search', [
            'query' => 'test',
            'cursor' => '-1'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'id_str' => '6649',
                'user' => [
                    'id_str' => '108316',
                    'name' => 'Tabitha Borer',
                    'screen_name' => 'gmarvin',
                ],
                'text' => 'Dolor eum doloribus culpa dignissimos. Voluptatum velit ducimus similique unde molestiae. Earum quam facilis enim ratione mollitia a eum.',
                'created_at' => 'Sat Aug 12 01:28:06 +0000 2017'
            ]);
    }

    public function test_cannot_fetch_search_results_without_query()
    {
        $response = $this->json('GET', 'api/search', [
            'query' => '',
            'cursor' => '-1'
        ]);

        $response->assertStatus(422)->assertJsonFragment(['query']);
    }

    public function test_cannot_fetch_search_results_without_cursor()
    {
        $response = $this->json('GET', 'api/search', [
            'query' => 'test',
            'cursor' => ''
        ]);

        $response->assertStatus(422)->assertJsonFragment(['cursor']);
    }
}
