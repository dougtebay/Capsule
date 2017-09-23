<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'twitter_user_id' => '823008709135704064',
            'name' => 'CapsuleWebApp',
            'nickname' => 'CapsuleWebApp'
        ]);
    }
}
