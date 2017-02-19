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
            'user_id' => $formData->user_id,
            'title' => $formData->title,
            'description' => $formData->description,
            'private' => true
        ]);
    }
}
