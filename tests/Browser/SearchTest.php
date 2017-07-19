<?php

use App\User;
use Tests\DuskTestCase;
use Tests\Browser\Pages\HomePage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SearchTest extends DuskTestCase
{
	use DatabaseMigrations;

	protected $user;

	public function setUp()
	{
		parent::setUp();

		$this->user = factory(User::class)->create();
	}

	public function test_can_search_for_tweets()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
			->visit(new HomePage)
			->type('query', 'test')
			->press('Search')
			->pause(500)
			->assertSee('test');
		});
	}
}
