<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function login(){
        return view('auth.admin.login', [
            'title' => 'Admin Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if(Auth::guard('admin')->attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/admin/dashboard');
        }

        return back()->with('loginError', 'Invalid email or password.');
    }

    public function logout(){
        Auth::guard('admin')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
