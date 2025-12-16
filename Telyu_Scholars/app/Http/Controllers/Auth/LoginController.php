<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    
    protected function redirectTo()
    {
        $user = Auth::user();
        
        // --- ROLE-BASED REDIRECT LOGIC ---
        if ($user->role === 'admin') {
            return route('dashboard');
        }

        if ($user->role === 'scholar_provider') {
            return route('dashboard');
        }

     
        if ($user->role === 'student') {
            return route('dashboard'); 
        }

       
        return RouteServiceProvider::HOME; 
    }


    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

     public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
  
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

           

        $request->session()->regenerate();

        return redirect($this->redirectTo());


        }

        return back()->withErrors([
            'email' => 'you may enter the wrng email or password!'
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
