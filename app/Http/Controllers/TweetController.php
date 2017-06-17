<?php

namespace App\Http\Controllers;

use App\Tweet;
use App\Collection;

class TweetController extends Controller
{
	public function store()
	{
		$tweet = request()->get('tweet');
		$collection = Collection::find(request()->get('collectionId'));

		$collection->addTweet($tweet);
	}

	public function destroy($id)
    {
        Tweet::destroy($id);

        return response()->json(['success' => true]);
    }
}
