<?php

namespace App\Http\Controllers;

use App\Tweet;
use App\Collection;

class CollectionTweetsController extends Controller
{
	public function store(Collection $collection)
	{
		$collection->addTweet(request()->all());

		return response()->json(['success' => true]);
	}

	public function destroy(Collection $collection, Tweet $tweet)
    {
        $collection->removeTweet($tweet);

        return response()->json(['success' => true]);
    }
}
