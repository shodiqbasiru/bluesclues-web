<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function login(){
        return view('login', [
            'title' => 'Admin Login'
        ]);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/admin/dashboard');
        }

        return back()->with('loginError', 'Login Failed');
    }

    public function logout(){
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}