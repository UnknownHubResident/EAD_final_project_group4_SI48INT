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
        // 1. Check if the user is authenticated.
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // 2. Check if the user's role is in the list of required roles.
        // The in_array() function checks if a value exists in an array.
        if (!in_array($userRole, $roles)) {
            // Access denied
            return redirect('/dashboard')->with('error', "Access Denied. You do not have the required role privileges.");
        }

        // 3. User is authorized, proceed.
        return $next($request);
    }
}