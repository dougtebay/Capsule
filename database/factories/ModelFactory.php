<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {

    return [
        'twitter_user_id' => (string) $faker->unique()->randomNumber,
        'name' => $faker->name,
        'nickname' => $faker->userName,
        'remember_token' => str_random(10),
    ];
});
