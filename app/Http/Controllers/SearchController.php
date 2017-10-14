<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Contracts\SocialNetworkAdapter;

class SearchController extends Controller
{
    protected $socialNetworkAdapter;

    public function __construct(SocialNetworkAdapter $socialNetworkAdapter)
    {
        $this->socialNetworkAdapter = $socialNetworkAdapter;
    }

    public function index()
    {
        $this->validate(request(), [
            'query' => 'required',
            'cursor' => 'required'
        ]);

        $query = request()->get('query');
        $cursor = request()->get('cursor');

        return $this->socialNetworkAdapter->search($query, $cursor);
    }
}
