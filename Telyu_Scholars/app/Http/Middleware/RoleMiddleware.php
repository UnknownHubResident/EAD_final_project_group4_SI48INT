<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // If user is not logged in → redirect to login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // If user role is NOT in allowed roles → deny access
        if (!in_array($user->role, $roles)) {

            // If request is expecting JSON (API)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized access'
                ], 403);
            }

            // Normal UI request → redirect with message
            return redirect()->route('home')
                ->with('error', 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}
