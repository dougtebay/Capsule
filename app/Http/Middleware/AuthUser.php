<?php

namespace App\Http\Middleware;

use Closure;

class AuthUser
{
    public function handle($request, Closure $next)
    {
        abort_if(request()->route('user')->id !== auth()->guard('api')->user()->id, 403);

        return $next($request);
    }
}
