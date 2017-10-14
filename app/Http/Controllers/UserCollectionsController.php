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
        return $user->addCollection(request()->only('title', 'description', 'public'));
    }

    public function update(SaveCollection $request, User $user, string $collectionId)
    {
        return $user->updateCollection(
            $collectionId,
            request()->only('title', 'description', 'public')
        );
    }

    public function destroy(User $user, string $collectionId)
    {
        $user->removeCollection($collectionId);

        return ['success' => true];
    }
}
