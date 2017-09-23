<?php

namespace App\Http\Middleware;

use Closure;
use App\Collection;

class AuthUserCollection
{
    public function handle($request, Closure $next)
    {
        $collection = request()->route('collection');

        abort_if(!auth()->guard('api')->user()->collections->contains($collection), 403);

        return $next($request);
    }
}
