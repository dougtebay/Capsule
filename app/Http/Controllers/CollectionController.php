<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        $userId = auth()->user() ? auth()->user()->id : null;
        $collections = Collection::where('user_id', $userId)->get();

        return response()->json($collections);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        auth()->user()->addCollection($request->all());

        return response()->json(['success' => true]);
    }

    public function show(Collection $collection)
    {
        if ($collection->load('tweets')->user_id === auth()->user()->id) {
            return response()->json($collection);
        }
    }

    public function update(Request $request, Collection $collection)
    {
        $collection->update([
            'title' => $request->collection['title'],
            'description' => $request->collection['description'],
            'public' => isset($request->collection['public'])
        ]);
    }

    public function destroy($id)
    {
        Collection::destroy($id);

        return response()->json(['success' => true]);
    }
}
