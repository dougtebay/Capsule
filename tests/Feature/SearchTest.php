<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Contracts\SocialNetworkAdapter;
use App\Services\FakeSocialNetworkAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        app()->instance(SocialNetworkAdapter::class, new FakeSocialNetworkAdapter);
    }

    public function test_can_get_search_results()
    {
        $response = $this->json('GET', 'api/search', [
            'query' => 'test',
            'cursor' => '-1'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id_str',
                'user',
                'text',
                'created_at'
            ]);
    }

    public function test_cannot_get_search_results_without_query()
    {
        $response = $this->json('GET', 'api/search', [
            'query' => '',
            'cursor' => '-1'
        ]);

        $response->assertStatus(422)->assertJsonFragment(['query']);
    }

    public function test_cannot_get_search_results_without_cursor()
    {
        $response = $this->json('GET', 'api/search', [
            'query' => 'test',
            'cursor' => ''
        ]);

        $response->assertStatus(422)->assertJsonFragment(['cursor']);
    }
}
