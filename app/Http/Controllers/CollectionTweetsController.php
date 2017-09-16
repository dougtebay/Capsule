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
        $this->validate(request(), [
            'id_str' => 'required',
            'user.id_str' => 'required',
            'user.name' => 'required',
            'user.screen_name' => 'required',
            'text' => 'required',
            'created_at' => 'required'
        ]);

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
