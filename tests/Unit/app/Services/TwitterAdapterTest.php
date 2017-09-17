<?php

namespace Tests\Unit\App\Services;

use Tests\TestCase;
use App\Contracts\SocialNetworkAdapter;

class SocialNetworkAdapterTest extends TestCase
{
    protected $socialNetworkAdapter;

    public function setUp()
    {
        parent::setUp();

        $this->socialNetworkAdapter = app(SocialNetworkAdapter::class);
    }

    public function test_it_can_search_for_results()
    {
        $results = $this->socialNetworkAdapter->search('test', '-1');

        $this->assertNotEmpty($results);
        $this->assertObjectHasAttribute('id_str', $results[0]);
        $this->assertObjectHasAttribute('user', $results[0]);
        $this->assertObjectHasAttribute('id_str', $results[0]->user);
        $this->assertObjectHasAttribute('name', $results[0]->user);
        $this->assertObjectHasAttribute('screen_name', $results[0]->user);
        $this->assertObjectHasAttribute('text', $results[0]);
        $this->assertObjectHasAttribute('created_at', $results[0]);
    }

    public function test_it_can_search_for_more_results_by_cursor()
    {
        $results = $this->socialNetworkAdapter->search('test', '-1');
        $resultsLast = $results[count($results) - 1];

        $moreResults = $this->socialNetworkAdapter->search('test', $resultsLast->id_str);
        $moreResultsFirst = $moreResults[0];

        $this->assertEquals($resultsLast->id_str, $moreResultsFirst->id_str);
    }
}
