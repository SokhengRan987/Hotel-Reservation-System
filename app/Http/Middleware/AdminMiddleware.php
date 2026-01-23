<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

            /** @var \App\Models\User $user */
        $user = auth()->user();

        if (!$user->isAdmin()) {
            abort(403);
        }

        return $next($request);
    }
}

