<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;
use PHPUnit\Framework\Assert as PHPUnit;

class SearchPage extends BasePage
{
    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function url()
    {
        return '/search';
    }

    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
            ->assertQueryStringHas('query', $this->query);

        if ($this->query) {
            $browser->waitForText('Save');
        } else {
            $browser->waitForText('No results');
        }
    }

    public function elements()
    {
        return [
            '@results' => '.card'
        ];
    }

    public function assertGreaterThan(Browser $browser, int $expected, int $actual)
    {
        PHPUnit::assertGreaterThan($expected, $actual);
    }
}
