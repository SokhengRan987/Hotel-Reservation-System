<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || (auth()->user()->role ?? '') !== 'admin') {
            // Option A: redirect to home with message
            return redirect()->route('home')->with('error', 'Unauthorized.');

            // Option B: return abort(403);
            // return abort(403);
        }

        return $next($request);
    }
}
