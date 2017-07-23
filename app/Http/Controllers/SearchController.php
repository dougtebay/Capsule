<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Adapters\TwitterAdapter;

class SearchController extends Controller
{
    public function index()
    {
    	$this->validate(request(), [
    		'user_id' => 'required',
            'query' => 'required',
            'max_id' => 'sometimes'
    	]);

        $user = User::find(request()->get('user_id'));
    	$query = request()->get('query');
        $maxId = request()->get('max_id');

        $twitterAdapter = new TwitterAdapter($user);
        $results = $twitterAdapter->search($query, $maxId);

        return response()->json($results);
    }
}
