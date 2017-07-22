<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class SearchPage extends BasePage
{
	public function __construct(string $query, string $userId)
    {
        $this->query = $query;
        $this->userId = $userId;
    }

	public function url()
	{
		return '/search';
	}

	public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
	        ->assertQueryStringHas('query', $this->query)
	        ->assertQueryStringHas('userId', $this->userId);
    }
}
