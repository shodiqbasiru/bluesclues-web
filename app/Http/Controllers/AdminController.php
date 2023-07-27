<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function login()
    {
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


        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/admin/dashboard');
        }

        return back()->with('loginError', 'Invalid email or password.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }

    public function index(Request $request)
    {

        // item number pagination
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $startIndex = ($currentPage - 1) * $perPage + 1;

        $searchQuery = $request->input('search');

        $admins = Admin::latest();

        if (!empty($searchQuery)) {
            $admins->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', "%$searchQuery%")
                ->orWhere('email', 'like', "%$searchQuery%");
            });
        }


        $admins = $admins->paginate($perPage)->appends(['search' => $searchQuery]);

        return view('dashboard.admin-accounts.index', [
            'title' => 'Admins',
            'admins' => $admins,
            'startIndex' => $startIndex,
            'searchQuery' => $searchQuery,
        ]);
    }

    public function create()
    {
        //
        return view('dashboard.admin-accounts.add', [
            'title' => 'Admins'
        ]);
    }

    public function store(Request $request)
    {
        // Validate
        $validatedData = $request->validate(
            [
                'name' => 'required|min:5|max:255',
                'email' => 'required|email:dns|unique:admins',
                'password' => 'required|min:8|max:255|confirmed',
            ]
        );

        // Create Admin
        $validatedData['password'] = Hash::make($validatedData['password']);
        Admin::create($validatedData);
        return redirect('/admin/dashboard/admins')->with('success', 'Account has been added!');
    }

    public function destroy(Admin $admin)
    {
        //
        Admin::destroy($admin->id);
        return redirect('/admin/dashboard/admins')->with('success', 'Account has been deleted!');
    }

    public function edit()
    {
        //
        $admin = Auth::guard('admin')->user();
        return view('dashboard.admin-accounts.edit', [
            'title' => 'Admins',
            'admin' => $admin

        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();
        $currentPassword = $request->input('current_password');

        if (Hash::check($currentPassword, $admin->password)) {
            $admin->update([
                'password' => Hash::make($request->input('password')),
            ]);

            return redirect('/admin/dashboard/admins')->with('success', 'Password changed successfully.');
        } else {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    }

    

}
