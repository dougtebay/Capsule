<?php

namespace Tests\Browser;

use App\User;
use App\Collection;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCollectionsTest extends DuskTestCase
{
	use DatabaseMigrations;

	public function test_user_can_view_their_collections()
	{
		$user = factory(User::class)->create();
		$collections = factory(Collection::class, 3)->create();

		$collections->each(function ($collection) use ($user) {
			$user->collections()->save($collection);
		});

		$this->browse(function ($browser) use ($user) {
			$browser->loginAs($user)
			->visit('/')
			->clickLink('My Collections')
			->assertPathIs("/users/{$user->id}/collections")
			->waitForText('Capsule')
			->assertSee($user->collections->first()->title)
			->assertSee($user->collections->first()->description)
			->assertSee($user->collections->last()->title)
			->assertSee($user->collections->last()->description);
		});
	}
}