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
            return redirect()->route('dashboard')
                ->with('error', 'You are not authorized to access this page.');
        }

        if ($user->role === 'scholar_provider' && !$user->is_approved) {
            
            // Check if user is rejected/suspended (optional custom message)
            if ($user->is_rejected) {
                $errorMessage = 'Access Denied. Your account has been suspended.';
            } else {
                $errorMessage = 'Access Denied. Your Scholar Provider application is still pending Admin approval.';
            }

            // Deny access
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $errorMessage
                ], 403);
            }

            return redirect()->route('dashboard')
                ->with('error', $errorMessage);
        }

        return $next($request);
    }
}
