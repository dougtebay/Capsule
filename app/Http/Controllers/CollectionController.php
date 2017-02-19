<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display a listing of the collection.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user() ? auth()->user()->id : null;
        $collections = Collection::where('user_id', $userId)->get();

        return view('collection.index', compact('collections'));
    }

    /**
     * Show the form for creating a new collection.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('collection.create');
    }

    /**
     * Store a newly created collection in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Collection::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'private' => true
        ]);
    }

    /**
     * Display the specified collection.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified collection.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified collection in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified collection from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}