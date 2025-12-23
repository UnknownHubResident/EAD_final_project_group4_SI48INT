<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @param string ...$roles The roles required for access (e.g., 'admin', 'editor')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Check if the user's role is in the list of required roles
        if (!in_array($userRole, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized access'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page.');
        }

        // User is authorized, proceed
        return $next($request);
    }
}