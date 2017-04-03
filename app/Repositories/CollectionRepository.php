<?php

namespace App\Repositories;

use App\Collection;

class CollectionRepository
{
    public function create(array $formData)
    {
        return Collection::create([
            'user_id' => auth()->user()->id,
            'title' => $formData['title'],
            'description' => $formData['description'],
            'public' => isset($formData['public'])
        ]);
    }
}
