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

    /**
     * Display a listing of collections.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $collections = auth()->user() ? Collection::currentUser()->get() : null;

        return view('collection.index', compact('collections'));
    }

    /**
     * Show the form for creating a new collection.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('collection.create');
    }

    /**
     * Store a newly created collection in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function store(Request $request)
    {
        $formData = (object) $request->all();

        $collection = $this->collectionRepository->create($formData);

        return redirect()->action('CollectionController@show', compact('collection'));
    }

    /**
     * Display the specified collection.
     *
     * @param  \App\Collection  $collection
     * @return \Illuminate\View\View
     */
    public function show(Collection $collection)
    {
        return view('collection.show', compact('collection'));
    }

    /**
     * Show the form for editing the specified collection.
     *
     * @param  \App\Collection  $collection
     * @return \Illuminate\View\View
     */
    public function edit(Collection $collection)
    {
        return view('collection.edit', compact('collection'));
    }

    /**
     * Update the specified collection in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Collection  $collection
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function update(Request $request, Collection $collection)
    {
        $collection->update([
            'title' => $request->title,
            'description' => $request->description,
            'public' => isset($request->public)
        ]);

        return redirect()->action('CollectionController@show', compact('collection'));
    }

    /**
     * Remove the specified collection from storage.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function destroy($id)
    {
        Collection::destroy($id);

        return redirect()->action('CollectionController@index');
    }
}