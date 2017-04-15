<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;
use App\Repositories\CollectionRepository;

class CollectionController extends Controller
{
    protected $collectionRepository;

    public function __construct(CollectionRepository $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    public function index()
    {
        if (!request()->ajax()) {
            return redirect('/');
        }

        $userId = auth()->user() ? auth()->user()->id : null;
        $collections = Collection::where('user_id', $userId)->get();

        return response()->json($collections);
    }

    public function create()
    {
        return view('collection.create');
    }

    public function store(Request $request)
    {
        $collection = $this->collectionRepository->create($request->collection);

        return response()->json(['success' => true]);
    }

    public function show(Collection $collection)
    {
        $collection->load('tweets');

        return response()->json($collection);
    }

    public function edit(Collection $collection)
    {
        return view('collection.edit', compact('collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        $collection->update([
            'title' => $request->title,
            'description' => $request->description,
            'public' => isset($request->public)
        ]);

        return redirect()->action('CollectionController@show', compact('collection'));
    }

    public function destroy($id)
    {
        Collection::destroy($id);

        return redirect()->action('CollectionController@index');
    }
}
