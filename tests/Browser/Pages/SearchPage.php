<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class SearchPage extends BasePage
{
	public function __construct(string $userId, string $query)
    {
    	$this->userId = $userId;
        $this->query = $query;
    }

	public function url()
	{
		return '/search';
	}

	public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
        	->assertQueryStringHas('userId', $this->userId)
	        ->assertQueryStringHas('query', $this->query);
    }
}
