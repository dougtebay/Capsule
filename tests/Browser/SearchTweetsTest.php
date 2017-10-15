<?php

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\SearchPage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SearchTweetsTest extends DuskTestCase
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

    public function test_can_search_for_tweets()
    {
        $query = 'test';

        $this->browse(function ($browser) use ($query) {
            $this->loginAndVisitHomePage($browser)
                ->search($query)
                ->on(new SearchPage($query, $this->user->id))
                ->assertSee('Save');
        });
    }

    public function test_can_search_for_more_tweets()
    {
        $query = 'test';

        $this->browse(function ($browser) use ($query) {
            $this->loginAndVisitHomePage($browser)
                ->search($query)
                ->on(new SearchPage($query, $this->user->id));

            $results = count($browser->elements('@results'));

            $browser->assertGreaterThan(0, $results)
                ->driver->executeScript('window.scrollTo(0, document.body.scrollHeight);');

            $browser->waitFor('#' . (string) ($results + 1));
            $results = count($browser->elements('@results'));

            $browser->assertGreaterThan(15, $results);
        });
    }

    public function test_cannot_search_for_tweets_without_query()
    {
        $query = '';

        $this->browse(function ($browser) use ($query) {
            $this->loginAndVisitHomePage($browser)
                ->search($query)
                ->on(new SearchPage($query, $this->user->id))
                ->assertDontSee('Save');
        });
    }
}
