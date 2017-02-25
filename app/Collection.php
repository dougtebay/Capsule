<?php

namespace App;

use stdClass;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the user that owns the collection.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
