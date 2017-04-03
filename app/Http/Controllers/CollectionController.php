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

    public function create()
    {
        return view('collection.create');
    }

    public function store(Request $request)
    {
        $formData = $request->all();

        $collection = $this->collectionRepository->create($formData);

        return redirect()->action('CollectionController@show', compact('collection'));
    }

    public function show(Collection $collection)
    {
        return view('collection.show', compact('collection'));
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
