<?php

namespace Tests\Browser;

use App\User;
use App\Tweet;
use App\Collection;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\SearchPage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\UserCollections\CollectionsShowPage;

class CollectionTweetsTest extends DuskTestCase
{
	use DatabaseMigrations;

	protected $user;

	public function setUp()
	{
		parent::setUp();

		$this->user = factory(User::class)->create();

		$this->collection = factory(Collection::class)->create();

		$this->user->collections()->save($this->collection);
	}

	protected function loginAndVisitHomePage(Browser $browser)
	{
		return $browser->loginAs($this->user)
			->visit(new HomePage);
	}

	public function test_can_add_tweet_to_collection()
	{
		$query = 'test';

		$this->browse(function ($browser) use ($query) {
			$this->loginAndVisitHomePage($browser)
				->search($query)
				->on(new SearchPage($query, $this->user->id))
				->select('collections', $this->collection->id)
				->press('Save')
				->waitForText("Saved to {$this->collection->title}")
				->assertSee("Saved to {$this->collection->title}")
				->visit(new CollectionsShowPage($this->user, $this->collection))
				->waitForText($this->collection->title)
				->assertVisible('.tweet-text');
		});
	}

	public function test_can_remove_tweet_from_collection()
	{
		$tweet = factory(Tweet::class)->create();

		$this->user->collections->first()->addTweet($tweet);

		$this->browse(function ($browser) use ($tweet) {
			$this->loginAndVisitHomePage($browser)
				->visit(new CollectionsShowPage($this->user, $this->collection))
				->waitForText($this->collection->title)
				->assertSee($tweet->text)
				->clickLink('Delete')
				->waitUntilMissing("#{$tweet->id}")
				->assertDontSee($tweet->text);
		});
	}
}
