<?php

namespace Tests\Browser;

use App\User;
use App\Collection;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\UserCollections\EditPage;
use Tests\Browser\Pages\UserCollections\ShowPage;
use Tests\Browser\Pages\UserCollections\IndexPage;
use Tests\Browser\Pages\UserCollections\CreatePage;
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
			$this->user->collections()->save($collection);
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
				->on(new IndexPage($this->user));
		});
	}

	public function test_can_visit_create_page()
	{
		$this->browse(function ($browser) {
			$this->loginAndVisitHomePage($browser)
				->clickLink('Add Collection')
				->on(new CreatePage($this->user));
		});
	}

	public function test_can_create_collection()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
				->visit(new CreatePage($this->user))
				->fillOutForm('Test Title', 'Test description')
				->assertSee('Test Title')
				->assertSee('Test description');
		});
	}

	public function test_cannot_create_collection_without_title()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
				->visit(new CreatePage($this->user))
				->fillOutForm('', 'Test description')
				->assertSee('title field is required');
		});
	}

	public function test_cannot_create_collection_with_long_title()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
				->visit(new CreatePage($this->user))
				->fillOutForm(str_random(51), 'Test description')
				->assertSee('title may not be greater than');
		});
	}

	public function test_cannot_create_collection_with_long_description()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
				->visit(new CreatePage($this->user))
				->fillOutForm('Test Title', str_random(101))
				->assertSee('description may not be greater than');
		});
	}

	public function test_can_visit_show_page()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$browser->loginAs($this->user)
				->visit(new IndexPage($this->user))
				->clickLink('View')
				->waitForText(config('app.name'))
				->on(new ShowPage($this->user, $collection))
				->assertSee($collection->title)
				->assertSee($collection->description);
		});
	}

	public function test_can_visit_edit_page()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$browser->loginAs($this->user)
				->visit(new IndexPage($this->user))
				->clickLink('Edit')
				->waitForText(config('app.name'))
				->on(new EditPage($this->user, $collection));
		});
	}

	public function test_can_edit_collection()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$browser->loginAs($this->user)
				->visit(new EditPage($this->user, $collection))
				->fillOutForm('Test Title', 'Test description')
				->on(new ShowPage($this->user, $collection))
				->assertSee('Test Title')
				->assertSee('Test description');
		});
	}

	public function test_can_delete_collection()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$browser->loginAs($this->user)
				->visit(new IndexPage($this->user))
				->clickLink('Delete')
				->waitForText(config('app.name'))
				->assertDontSee($collection->title)
				->assertDontSee($collection->description);
		});
	}
}
