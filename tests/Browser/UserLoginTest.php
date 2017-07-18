<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
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

	protected function loginAndVisitHomePage(Browser $browser)
	{
		return $browser->loginAs($this->user)
			->visit(new HomePage);
	}

	public function test_user_can_see_login_page()
	{
		$this->browse(function ($browser) {
			$browser->visit(new HomePage)
			->clickLink('Login')
			->assertSee('Twitter');
		});
	}

	public function test_user_can_log_in()
	{
		$this->browse(function ($browser) {
			$this->loginAndVisitHomePage($browser)
			->assertSee($this->user->name);
		});
	}

	public function test_user_can_log_out()
	{
		$this->browse(function ($browser) {
			$this->loginAndVisitHomePage($browser)
			->clickLink('Logout')
			->waitForText(config('app.name'))
			->assertSee('Login');
		});
	}
}
