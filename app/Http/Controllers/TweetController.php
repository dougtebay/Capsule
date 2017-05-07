<?php

namespace App\Http\Controllers;

use App\Collection;

class TweetController extends Controller
{
	public function store()
	{
		$tweet = request()->get('tweet');
		$collection = Collection::find(request()->get('collectionId'));

		$collection->addTweet($tweet);
	}
}
