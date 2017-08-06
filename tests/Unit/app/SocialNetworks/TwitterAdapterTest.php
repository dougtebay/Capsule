<?php

namespace Tests\Unit\App\SocialNetworks;

use Tests\TestCase;
use App\SocialNetworks\Twitter;
use App\SocialNetworks\TwitterAdapter;

class TwitterAdapterTest extends TestCase
{
	protected $twitterAdapter;

	public function setUp()
	{
		parent::setUp();

		$this->twitterAdapter = new TwitterAdapter(new Twitter);
	}

	public function test_it_can_search_for_tweets()
	{
		$results = $this->twitterAdapter->search('test', '-1');

		$this->assertNotEmpty($results);
		$this->assertObjectHasAttribute('id_str', $results[0]);
		$this->assertObjectHasAttribute('user', $results[0]);
		$this->assertObjectHasAttribute('id_str', $results[0]->user);
		$this->assertObjectHasAttribute('name', $results[0]->user);
		$this->assertObjectHasAttribute('screen_name', $results[0]->user);
		$this->assertObjectHasAttribute('text', $results[0]);
		$this->assertObjectHasAttribute('created_at', $results[0]);
	}

	public function test_it_can_search_for_more_tweets_by_cursor()
	{
		$results = $this->twitterAdapter->search('test', '-1');
		$resultsLast = $results[count($results) - 1];

		$moreResults = $this->twitterAdapter->search('test', $resultsLast->id_str);
		$moreResultsFirst = $moreResults[0];

		$this->assertEquals($resultsLast->id_str, $moreResultsFirst->id_str);
	}
}
