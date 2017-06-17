<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adapters\TwitterAdapter;

class SearchController extends Controller
{
    public function index(Request $request, TwitterAdapter $twitterAdapter)
    {
    	$this->validate($request, [
    		'query' => 'required'
    	]);

    	$query = request()->get('query');
        $maxId = request()->get('max_id');

        $results = $twitterAdapter->search($query, $maxId);

        return response()->json($results);
    }
}
