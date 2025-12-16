<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
       
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        
        if (!in_array($user->role, $roles)) {
             // ... JSON response or redirect to dashboard (this logic is fine)
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized access'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page.');
        }

       

        return $next($request);
    }
}