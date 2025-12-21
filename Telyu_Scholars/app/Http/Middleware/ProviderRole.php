<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProviderRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      if (!Auth::check()) {
        return redirect('/login');
    }

    $user = Auth::user();

    if ($user->role !== 'scholar_provider') {
        return redirect('/')->with('error', 'Access denied.');
    }

    if (!$user->is_approved || $user->is_rejected) {
        return redirect('/dashboard'); 
    }
    
    return $next($request);
    }
}

