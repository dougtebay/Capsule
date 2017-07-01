<?php

namespace Tests\Browser;

use App\User;
use App\Collection;
use Tests\DuskTestCase;
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

	protected function logInAndVisitUserCollections($browser)
	{
		return $browser->loginAs($this->user)
			->visit('/')
			->clickLink('My Collections');
	}

	public function test_user_can_view_collections()
	{
		$this->browse(function ($browser) {
			$this->logInAndVisitUserCollections($browser)
			->waitForText(config('app.name'))
			->assertPathIs("/users/{$this->user->id}/collections")
			->assertSee($this->user->collections->first()->title)
			->assertSee($this->user->collections->first()->description)
			->assertSee($this->user->collections->last()->title)
			->assertSee($this->user->collections->last()->description);
		});
	}

	public function test_user_can_view_collection()
	{
		$collection = $this->user->collections->first();

		$this->browse(function ($browser) use ($collection) {
			$this->logInAndVisitUserCollections($browser)
			->waitForText(config('app.name'))
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
			->waitForText(config('app.name'))
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
			->waitForText(config('app.name'))
			->clickLink('Edit')
			->waitForText(config('app.name'))
			->type('title', 'Test Title')
			->type('description', 'Test description')
			->press('Submit')
			->pause(500)
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
			->waitForText(config('app.name'))
			->clickLink('Delete')
			->waitForText(config('app.name'))
			->assertDontSee($collection->title)
			->assertDontSee($collection->description);
		});
	}
}
