<?php

namespace Tests\Unit\App\Repositories;

use Faker;
use App\User;
use Tests\TestCase;
use App\Repositories\Users;
use Laravel\Socialite\One\User as TwitterUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;
    protected $twitterUser;
    protected $faker;
    protected $users;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->twitterUser = new TwitterUser();
        $this->faker = Faker\Factory::create();
        $this->twitterUser->name = $this->faker->name;
        $this->twitterUser->nickname = $this->faker->userName;

        $this->users = new Users();
    }

    public function testItCanFindExistingUser()
    {
        $this->twitterUser->user = ['id_str' => $this->user->twitter_user_id];

        $user = $this->users->findOrCreate($this->twitterUser);

        $this->assertEquals($this->user->id, User::all()->last()->id);
    }

    public function testItCanCreateNewUser()
    {
        $this->twitterUser->user = ['id_str' => $this->faker->randomNumber];

        $user = $this->users->findOrCreate($this->twitterUser);

        $this->assertGreaterThan($this->user->id, User::all()->last()->id);
        $this->assertEquals($this->twitterUser->user['id_str'], $user->twitter_user_id);
        $this->assertEquals($this->twitterUser->name, $user->name);
        $this->assertEquals($this->twitterUser->nickname, $user->nickname);
    }
}
