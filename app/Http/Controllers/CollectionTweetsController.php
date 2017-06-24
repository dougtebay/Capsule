<?php

namespace App\Http\Controllers;

use App\Tweet;
use App\Collection;
use App\Repositories\Tweets;

class CollectionTweetsController extends Controller
{
	protected $tweets;

	public function __construct(Tweets $tweets)
	{
		$this->tweets = $tweets;
	}

	public function store(Collection $collection)
	{
		$tweet = $this->tweets->findOrCreate(request()->all());

		$collection->addTweet($tweet);

		return response()->json(['success' => true]);
	}

	public function destroy(Collection $collection, Tweet $tweet)
    {
        $collection->removeTweet($tweet);

        return response()->json(['success' => true]);
    }
}
