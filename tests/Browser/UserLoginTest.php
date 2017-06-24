<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserLoginTest extends DuskTestCase
{
	use DatabaseMigrations;

	public function test_user_can_log_in()
	{
		$user = factory(User::class)->create();

		$this->browse(function ($browser) use ($user) {
			$browser->loginAs($user)
			->visit('/')
			->assertSee($user->name);
		});
	}
}
