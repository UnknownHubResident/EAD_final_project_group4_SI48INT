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
        $user = Auth::user();
        
       
        if (!Auth::check() || $user->role !== 'scholar_provider') {
            return redirect('/')->with('error', 'Access denied. You must be a Scholar Provider.');
        }

       
        if (!$user->is_approved || $user->is_rejected) {
            $errorMessage = $user->is_rejected 
                ? 'Access Denied. Your account has been suspended by an Admin.' 
                : 'Access Denied. Your Scholar Provider account is still pending Admin approval.';
            
           
            return redirect('/dashboard')->with('error', $errorMessage);
        }
        
        return $next($request);
    }
}

