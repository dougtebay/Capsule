<?php

namespace Tests\Unit\App\Repositories;

use Faker;
use App\User;
use Tests\TestCase;
use App\Repositories\Users;
use Laravel\Socialite\One\User as TwitterUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    protected $users;

    protected function setUp()
    {
        parent::setUp();

        $this->users = new Users();
    }

    protected function twitterUser()
    {
        $twitterUser = new TwitterUser();

        $twitterUser->user = ['id_str' => (string) Faker\Factory::create()->unique()->randomNumber];
        $twitterUser->name = Faker\Factory::create()->name;
        $twitterUser->nickname = Faker\Factory::create()->userName;
        $twitterUser->token = config('services.twitter.token');
        $twitterUser->tokenSecret = config('services.twitter.token_secret');

        return $twitterUser;
    }

    public function test_it_can_create_user()
    {
        $twitterUser = $this->twitterUser();

        $user = $this->users->updateOrCreate($twitterUser);

        $this->assertEquals($twitterUser->user['id_str'], $user->twitter_user_id);
        $this->assertEquals(User::first()->id, $user->id);
    }

    public function test_it_can_update_user()
    {
        $twitterUser = $this->twitterUser();

        $this->users->updateOrCreate($twitterUser);
        $twitterUser->name = Faker\Factory::create()->name;
        $user = $this->users->updateOrCreate($twitterUser);

        $this->assertEquals(1, User::all()->count());
        $this->assertEquals($twitterUser->name, $user->name);
    }
}
