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
        'twitter_token' => config('services.twitter.token'),
        'twitter_token_secret' => config('services.twitter.token_secret'),
        'api_token' => str_random(60)
    ];
});

$factory->define(App\Collection::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'title' => $faker->text(50),
        'description' => $faker->text(100),
        'public' => $faker->numberBetween(0, 1)
    ];
});

$factory->define(App\Tweet::class, function (Faker\Generator $faker) {
    return [
        'twitter_tweet_id' => (string) $faker->unique()->randomNumber,
        'twitter_user_id' => (string) $faker->unique()->randomNumber,
        'user_name' => $faker->name,
        'user_nickname' => $faker->userName,
        'text' => $faker->text(140),
        'twitter_created_at' => date('Y-m-d H:i:s')
    ];
});
