<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectToApi
{
    public function handle($request, Closure $next)
    {
        if (!request()->ajax()) {
            $requestUri = str_replace(config('app.url'), '', request()->fullUrl());

            return redirect('/')->with('requestUri', $requestUri);
        }

        return $next($request);
    }
}
