<?php

use App\Tweet;
use App\Collection;
use Illuminate\Database\Seeder;

class TweetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tweets = factory(Tweet::class, 30)->create();

        $collections = Collection::all();

        if ($collections->isNotEmpty()) {
            $tweets->each(function ($tweet) use ($collections) {
                $collections->random()->tweets()->attach($tweet);
            });
        }
    }
}
