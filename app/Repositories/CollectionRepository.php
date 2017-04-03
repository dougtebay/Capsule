<?php

namespace App\Repositories;

use stdClass;
use App\Collection;

class CollectionRepository
{
    public function create(stdClass $formData)
    {
        return Collection::create([
            'user_id' => auth()->user()->id,
            'title' => $formData->title,
            'description' => $formData->description,
            'public' => isset($formData->public)
        ]);
    }
}
