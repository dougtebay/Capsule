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

    public function test_user_can_search()
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
}
