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
        $results = $this->twitter->search($query)->statuses;

        return view('search.index', compact('results'));
    }
}
