<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Adapters\TwitterAdapter;

class SearchController extends Controller
{
    protected $twitterAdapter;

    public function __construct(TwitterAdapter $twitterAdapter)
    {
        $this->twitterAdapter = $twitterAdapter;
    }

    public function index()
    {
    	$this->validate(request(), [
    		'query' => 'required',
            'max_id' => 'sometimes'
    	]);

        $query = request()->get('query');
        $maxId = request()->get('max_id');

        $results = $this->twitterAdapter->search($query, $maxId);

        return response()->json($results);
    }
}
