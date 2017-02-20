<?php

namespace App\Repositories;

use stdClass;
use App\Collection;

class CollectionRepository
{
    /**
     * Create a collection.
     *
     * @param  stdClass  $collection
     * @return \App\Collection
     */
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
