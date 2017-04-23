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
        $userId = auth()->user() ? auth()->user()->id : null;
        $collections = Collection::where('user_id', $userId)->get();

        return response()->json($collections);
    }

    public function store(Request $request)
    {
        $collection = $this->collectionRepository->create($request->collection);

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

        return redirect()->action('CollectionController@index');
    }
}
