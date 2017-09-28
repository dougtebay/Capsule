<?php

namespace App\Http\Controllers;

use App\User;
use App\Collection;
use Illuminate\Http\Request;
use App\Http\Requests\SaveCollection;

class UserCollectionsController extends Controller
{
    public function index(User $user)
    {
        return $user->collections;
    }

    public function store(SaveCollection $request, User $user)
    {
        $user->addCollection(request()->only(['title', 'description', 'public']));

        return ['success' => true];
    }

    public function show(User $user, string $collectionId)
    {
        if (request('with-tweets') === 'true') {
            return $user->collections->find($collectionId)->load('tweets');
        }

        return $user->collections->find($collectionId);
    }

    public function update(SaveCollection $request, User $user, string $collectionId)
    {
        $user->updateCollection($collectionId, request()->only('title', 'description', 'public'));

        return ['success' => true];
    }

    public function destroy(User $user, string $collectionId)
    {
        $user->removeCollection($collectionId);

        return ['success' => true];
    }
}
