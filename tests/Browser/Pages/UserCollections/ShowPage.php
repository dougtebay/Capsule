<?php

namespace Tests\Browser\Pages\UserCollections;

use App\User;
use App\Collection;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class ShowPage extends BasePage
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
        return "/users/{$this->user->id}/collections/{$this->collection->id}";
    }

    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }
}
