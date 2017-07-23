<?php

namespace Tests\Browser\Pages\UserCollections;

use App\User;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class CollectionsCreatePage extends BasePage
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function url()
    {
        return "/users/{$this->user->id}/collections/create";
    }

    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
            ->assertSee('Title')
            ->assertSee('Description');
    }

    public function fillOutForm(Browser $browser, string $title, string $description)
    {
        $browser->type('title', $title)
            ->type('description', $description)
            ->press('Submit')
            ->pause(500);
    }
}
