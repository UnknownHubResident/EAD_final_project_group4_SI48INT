<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    protected $redirectTo = '/dashboard';

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
{
    // 1. Validate the incoming request data
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    
    // 2. Find the user by email, regardless of their status or password.
    $user = User::where('email', $request->email)->first(); 

    // 3. CHECK FOR DEACTIVATION FIRST (Before allowing authentication)
    if ($user && $user->is_active === false) {

        // User found, but account is deactivated. BLOCK LOGIN and show specific message.
        return back()->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => "Your account has been deactivated. maybe dont be a naughty person next time?"
            ]);
    }
    
    // 4. ATTEMPT LOGIN (Now we only check email and password, as deactivation is handled)
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        
        // SUCCESS: Active user authenticated.
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
        
    }

    // 5. GENERIC FALLBACK
    // If we reach here, the failure was NOT due to deactivation (handled in step 3), 
    // it was due to Auth::attempt failing on email or password.
    return back()->withErrors([
        'email' => 'you may enter the wrong email or password!'
    ]);
}




public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout!');
    }

}

