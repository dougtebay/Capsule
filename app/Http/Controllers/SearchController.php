<?php

namespace App\Http\Controllers;

use App\Adapters\Twitter;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * The twitter adapter instance.
     *
     * @var \App\Adapters\Twitter
     */
    protected $twitter;

    /**
     * Create a new search controller.
     *
     * @param  \App\Adapters\Twitter  $twitter
     * @return void
     */
    public function __construct(Twitter $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * Show the search results.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $query = request()->get('query');
        $maxId = request()->get('max_id');

        $results = $this->twitter->search($query, $maxId);

        return view('search.index', compact('query', 'results'));
    }
}
