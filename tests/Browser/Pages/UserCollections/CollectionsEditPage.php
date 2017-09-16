<?php

namespace Tests\Browser\Pages\UserCollections;

use App\User;
use App\Collection;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class CollectionsEditPage extends BasePage
{
    protected $user;
    protected $collection;

    public function __construct(User $user, Collection $collection)
    {
        $this->user = $user;
        $this->collection = $collection;
    }

    public function url()
    {
        return "/users/{$this->user->id}/collections/{$this->collection->id}/edit";
    }

    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
            ->assertSee('Title')
            ->assertSee('Description');
    }

    public function fillOutForm(Browser $browser, string $title, string $description)
    {
        $browser->clear('title')
            ->type('title', $title)
            ->clear('description')
            ->type('description', $description)
            ->press('Submit');
    }
}
