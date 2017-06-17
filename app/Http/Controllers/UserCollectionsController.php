<?php

namespace App\Http\Controllers;

use App\User;
use App\Collection;
use Illuminate\Http\Request;

class UserCollectionsController extends Controller
{
    public function index(User $user)
    {
        return response()->json($user->collections);
    }

    public function store(User $user)
    {
        $this->validate(request(), [
            'title' => 'required'
        ]);

        $user->addCollection(request()->all());

        return response()->json(['success' => true]);
    }

    public function show($userId, Collection $collection)
    {
        return response()->json($collection);
    }

    public function update($userId, Collection $collection)
    {
        $this->validate(request(), [
            'title' => 'required'
        ]);

        $collection->update([
            'title' => request()->title,
            'description' => request()->description,
            'public' => isset(request()->public)
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy(User $user, $collectionId)
    {
        $user->removeCollection($collectionId);

        return response()->json(['success' => true]);
    }
}
