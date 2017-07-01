<?php

namespace Tests\Browser;

use App\User;
use App\Collection;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
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

	protected function logInAndVisitUserCollections(Browser $browser)
	{
		return $browser->loginAs($this->user)
			->visit('/')
			->clickLink('My Collections')
			->waitForText(config('app.name'));
	}

	protected function fillOutCollectionForm(Browser $browser, string $title, string $description)
	{
		return $browser->type('title', $title)
			->type('description', $description)
			->press('Submit')
			->pause(500);
	}

	public function test_user_can_view_collections()
	{
		$this->browse(function ($browser) {
			$this->logInAndVisitUserCollections($browser)
			->assertPathIs("/users/{$this->user->id}/collections")
			->assertSee($this->user->collections->first()->title)
			->assertSee($this->user->collections->first()->description)
			->assertSee($this->user->collections->last()->title)
			->assertSee($this->user->collections->last()->description);
		});
	}

	public function test_user_can_add_collection()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
			->visit('/')
			->clickLink('Add Collection')
			->waitForText(config('app.name'));
			$this->fillOutCollectionForm($browser, 'Test Title', 'Test description')
			->assertPathIs("/users/{$this->user->id}/collections")
			->assertSee('Test Title')
			->assertSee('Test description');
		});
	}

	public function test_user_cannot_add_collection_without_title()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
			->visit('/')
			->clickLink('Add Collection')
			->waitForText(config('app.name'));
			$this->fillOutCollectionForm($browser, '', 'Test description')
			->assertSee('title field is required');
		});
	}

	public function test_user_cannot_add_collection_with_long_title()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
			->visit('/')
			->clickLink('Add Collection')
			->waitForText(config('app.name'));
			$this->fillOutCollectionForm($browser, 'An absurdly long title that will not pass validation', 'Test description')
			->waitForText(config('app.name'))
			->assertSee('title may not be greater than');
		});
	}

	public function test_user_cannot_add_collection_with_long_description()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
			->visit('/')
			->clickLink('Add Collection')
			->waitForText(config('app.name'));
			$this->fillOutCollectionForm($browser, 'Test Title', 'A preposterously long description that seems to go on and on without end and will not pass validation')
			->waitForText(config('app.name'))
			->assertSee('description may not be greater than');
		});
	}

	public function test_user_can_view_collection()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$this->logInAndVisitUserCollections($browser)
			->clickLink('View')
			->waitForText(config('app.name'))
			->assertPathIs("/users/{$this->user->id}/collections/{$collection->id}")
			->assertSee($collection->title)
			->assertSee($collection->description);
		});
	}

	public function test_user_can_view_form_to_edit_collection()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$this->logInAndVisitUserCollections($browser)
			->clickLink('Edit')
			->waitForText(config('app.name'))
			->assertPathIs("/users/{$this->user->id}/collections/{$collection->id}/edit")
			->assertSee('Title');
		});
	}

	public function test_user_can_edit_collection()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$this->logInAndVisitUserCollections($browser)
			->clickLink('Edit')
			->waitForText(config('app.name'));
			$this->fillOutCollectionForm($browser, 'Test Title', 'Test description')
			->assertPathIs("/users/{$this->user->id}/collections/{$collection->id}")
			->assertSee('Test Title')
			->assertSee('Test description');
		});
	}

	public function test_user_can_delete_collection()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$this->logInAndVisitUserCollections($browser)
			->clickLink('Delete')
			->waitForText(config('app.name'))
			->assertDontSee($collection->title)
			->assertDontSee($collection->description);
		});
	}
}
