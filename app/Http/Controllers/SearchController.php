<?php

namespace App\Http\Controllers;

use App\Adapters\Twitter;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    protected $twitter;

    public function __construct(Twitter $twitter)
    {
        $this->twitter = $twitter;
    }

    public function index()
    {
        $query = request()->get('query');
        $maxId = request()->get('max_id');

        $results = $this->twitter->search($query, $maxId);

        return view('search.index', compact('results'));
    }
}
