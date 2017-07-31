<?php

namespace Tests\Browser;

use App\User;
use App\Collection;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\UserCollections\CollectionsEditPage;
use Tests\Browser\Pages\UserCollections\CollectionsShowPage;
use Tests\Browser\Pages\UserCollections\CollectionsIndexPage;
use Tests\Browser\Pages\UserCollections\CollectionsCreatePage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCollectionsTest extends DuskTestCase
{
	use DatabaseMigrations;

	protected $user;

	public function setUp()
	{
		parent::setUp();

		$this->user = factory(User::class)->create();
		$collections = factory(Collection::class, 3)->create();

		$collections->each(function ($collection) {
			$this->user->addCollection($collection->toArray());
		});
	}

	protected function loginAndVisitHomePage(Browser $browser)
	{
		return $browser->loginAs($this->user)
			->visit(new HomePage);
	}

	public function test_can_visit_index_page()
	{
		$this->browse(function ($browser) {
			$this->loginAndVisitHomePage($browser)
				->clickLink('My Collections')
				->on(new CollectionsIndexPage($this->user));
		});
	}

	public function test_can_visit_create_page()
	{
		$this->browse(function ($browser) {
			$this->loginAndVisitHomePage($browser)
				->clickLink('Add Collection')
				->on(new CollectionsCreatePage($this->user));
		});
	}

	public function test_can_create_collection()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
				->visit(new CollectionsCreatePage($this->user))
				->fillOutForm('Test Title', 'Test description')
				->waitForText('Test Title')
				->assertSee('Test Title')
				->assertSee('Test description');
		});
	}

	public function test_cannot_create_collection_without_title()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
				->visit(new CollectionsCreatePage($this->user))
				->fillOutForm('', 'Test description')
				->waitForText('title field is required')
				->assertSee('title field is required');
		});
	}

	public function test_cannot_create_collection_with_long_title()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
				->visit(new CollectionsCreatePage($this->user))
				->fillOutForm(str_random(51), 'Test description')
				->waitForText('title may not be greater than')
				->assertSee('title may not be greater than');
		});
	}

	public function test_cannot_create_collection_with_long_description()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
				->visit(new CollectionsCreatePage($this->user))
				->fillOutForm('Test Title', str_random(101))
				->waitForText('description may not be greater than')
				->assertSee('description may not be greater than');
		});
	}

	public function test_can_visit_show_page()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$browser->loginAs($this->user)
				->visit(new CollectionsIndexPage($this->user))
				->clickLink('View')
				->waitForText($collection->title)
				->on(new CollectionsShowPage($this->user, $collection))
				->assertSee($collection->title)
				->assertSee($collection->description);
		});
	}

	public function test_can_visit_edit_page()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$browser->loginAs($this->user)
				->visit(new CollectionsIndexPage($this->user))
				->clickLink('Edit')
				->waitForText('Title')
				->on(new CollectionsEditPage($this->user, $collection));
		});
	}

	public function test_can_edit_collection()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$newTitle = 'Test Title';
			$newDescription = 'Test description';

			$browser->loginAs($this->user)
				->visit(new CollectionsEditPage($this->user, $collection))
				->fillOutForm($newTitle, $newDescription)
				->waitForText($newTitle);

			$collection->title = $newTitle;
			$collection->description = $newDescription;

			$browser->on(new CollectionsShowPage($this->user, $collection))
				->assertSee($newTitle)
				->assertSee($newDescription);
		});
	}

	public function test_can_delete_collection()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$browser->loginAs($this->user)
				->visit(new CollectionsIndexPage($this->user))
				->clickLink('Delete')
				->waitUntilMissing("#{$collection->id}")
				->assertDontSee($collection->title)
				->assertDontSee($collection->description);
		});
	}
}
