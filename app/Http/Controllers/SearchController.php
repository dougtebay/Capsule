<?php

namespace App\Http\Controllers;

use App\Adapters\TwitterAdapter;
use App\Repositories\TweetRepository;

class SearchController extends Controller
{
    public function index(TwitterAdapter $twitterAdapter)
    {
    	if (!request()->ajax()) {
            $requestUri = str_replace(config('app.url'), '', request()->fullUrl());

            return redirect('/')->with('requestUri', $requestUri);
        }

        $query = request()->get('query');
        $maxId = request()->get('max_id');

        $results = $twitterAdapter->search($query, $maxId);

        return response()->json($results);
    }
}
