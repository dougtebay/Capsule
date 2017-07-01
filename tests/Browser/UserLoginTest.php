<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserLoginTest extends DuskTestCase
{
	use DatabaseMigrations;

	protected $user;

	public function setUp()
	{
		parent::setUp();

		$this->user = factory(User::class)->create();
	}

	public function test_user_can_see_login_page()
	{
		$this->browse(function ($browser) {
			$browser->visit('/')
			->clickLink('Login')
			->assertSee('Twitter');
		});
	}

	public function test_user_can_log_in()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
			->visit('/')
			->assertSee($this->user->name);
		});
	}

	public function test_user_can_log_out()
	{
		$this->browse(function ($browser) {
			$browser->loginAs($this->user)
			->visit('/')
			->clickLink('Logout')
			->waitForText(config('app.name'))
			->assertSee('Login');
		});
	}
}
