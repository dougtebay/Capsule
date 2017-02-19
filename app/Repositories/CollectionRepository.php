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
    public function create(stdClass $collectionData)
    {
        return Collection::create([
            'user_id' => $collectionData->user_id,
            'title' => $collectionData->title,
            'description' => $collectionData->description,
            'private' => true
        ]);
    }
}
