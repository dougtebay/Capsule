<?php

namespace Tests\Browser\Pages\UserCollections;

use App\User;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class CollectionsIndexPage extends BasePage
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function url()
    {
        return "/users/{$this->user->id}/collections";
    }

    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
            ->waitForText($this->user->collections->first()->title)
            ->assertSee($this->user->collections->first()->title)
            ->assertSee($this->user->collections->first()->description)
            ->assertSee($this->user->collections->last()->title)
            ->assertSee($this->user->collections->last()->description);
    }
}
