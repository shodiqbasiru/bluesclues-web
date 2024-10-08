<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    // Register
    public function register()
    {
        return view('auth.user.register', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request)
    {
        // Validate
        $validatedData = $request->validate(
            [
                'name' => 'required|min:5|max:255',
                'email' => 'required|email:dns|unique:users',
                'username' => 'required|min:5|max:255|unique:users',
                'password' => 'required|min:8|max:255|confirmed',
                'g-recaptcha-response' => 'required|captcha'
            ],
            [
                'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
                'g-recaptcha-response.captcha' => 'The reCAPTCHA verification failed. Please try again.'
            ]
        );

        // Create User
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        event(new Registered($user));

        return redirect('/login-user')->with('success', 'Registration successful!, please verify your email address by clicking the link sent to your email.');
    }

    public function login()
    {
        return view('auth.user.login', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {


            $request->session()->regenerate();
            
            $intendedUrl = $request->session()->pull('url.intended', '/store');

            return redirect()->intended($intendedUrl);
        }

        return back()->with('loginError', 'Email or Password is Wrong');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/store');
    }

    public function index(Request $request)
    {

        $status = $request->input('status');
        $users = User::query();

        if ($status === 'unverified') {
            $users->whereNull('email_verified_at');
        } elseif ($status === 'verified') {
            $users->whereNotNull('email_verified_at');
        }
        // item number pagination
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $startIndex = ($currentPage - 1) * $perPage + 1;

        $searchQuery = $request->input('search');


        if (!empty($searchQuery)) {
            $users->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', "%$searchQuery%")
                ->orWhere('email', 'like', "%$searchQuery%");
            });
        }

        $users->orderByDesc('created_at');


        $users = $users->paginate($perPage)->appends([
            'search' => $searchQuery,
            'status' => $status,
        ]);

        return view('dashboard.user-accounts.index', [
            'title' => 'Users',
            'users' => $users,
            'startIndex' => $startIndex,
            'searchQuery' => $searchQuery,
            'status' => $status
        ]);

        
    }
}