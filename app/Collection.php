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
     * Scope a query to only include the current user's collections.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrentUser($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }
}
