<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            Log::info('Unauthenticated access attempt to admin route', [
                'path' => $request->path(),
                'ip' => $request->ip(),
                'timestamp' => now(),
            ]);
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Check if user has admin role using Gate
        if (!Gate::allows('isAdmin')) {
            Log::warning('Unauthorized admin access attempted', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'path' => $request->path(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);
            abort(403, 'You do not have permission to access this resource.');
        }

        Log::info('Admin access granted', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'path' => $request->path(),
            'method' => $request->method(),
            'timestamp' => now(),
        ]);

        return $next($request);
    }
}

