<?php

namespace App\Http\Middleware;

use Closure;
use App\Collection;

class AuthUserCollection
{
    public function handle($request, Closure $next)
    {
        if ($collection = request()->route('collection')) {
            if (gettype($collection) === 'string') {
                $collection = Collection::find($collection);
            }

            if ($collection->user_id !== auth()->guard('api')->user()->id) {
                return redirect()->back()->setStatusCode(403);
            }
        }

        return $next($request);
    }
}
