<?php

namespace App\Http\Controllers;

use App\User;
use App\Collection;
use Illuminate\Http\Request;

class CollectionsController extends Controller
{
    public function index()
    {
        if (request()->scope === 'user') {
            $userId = auth()->user() ? auth()->user()->id : null;
            $collections = User::find($userId)->collections;

            return response()->json($collections);
        }

        $collections = Collection::all();

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
        $this->validate($request, [
            'title' => 'required'
        ]);

        $collection->update([
            'title' => $request->title,
            'description' => $request->description,
            'public' => isset($request->public)
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Collection::destroy($id);

        return response()->json(['success' => true]);
    }
}
