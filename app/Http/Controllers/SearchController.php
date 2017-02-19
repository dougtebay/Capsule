<?php

namespace App\Http\Controllers;

use App\Adapters\TwitterAdapter;
use App\Repositories\TweetRepository;

class SearchController extends Controller
{
    /**
     * Show the search results.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $query = request()->get('query');
        $maxId = request()->get('max_id');
        $twitterAdapter = new TwitterAdapter(new TweetRepository, session());

        $results = $twitterAdapter->search($query, $maxId);

        return view('search.index', compact('query', 'results'));
    }
}
