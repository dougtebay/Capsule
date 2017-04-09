<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Support\Facades\DB;
use App\Repositories\TweetRepository;
use App\Repositories\CollectionTweetRepository;

class TweetController extends Controller
{
	protected $tweetRepository;
	protected $collectionTweetRepository;

	public function __construct(TweetRepository $tweetRepository,
		CollectionTweetRepository $collectionTweetRepository)
	{
		$this->tweetRepository = $tweetRepository;
		$this->collectionTweetRepository = $collectionTweetRepository;
	}

	public function store()
	{
		$tweet = request()->get('tweet');
		$collectionId = request()->get('collectionId');

		DB::transaction(function () use ($tweet, $collectionId) {
			$tweet = $this->tweetRepository->create($tweet);
			$this->collectionTweetRepository->create($collectionId, $tweet->id);
		});
	}
}
