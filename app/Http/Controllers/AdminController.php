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
        if (Auth::guard('admin')->user()->id == 1) {
            return view('dashboard.admin-accounts.add', [
                'title' => 'Admins'
            ]);
        } else {
            return redirect('/admin/dashboard/admins')->withErrors(['error' => 'Only the super admin can add accounts']);
        }
    }

    public function store(Request $request)
    {
        // Validate
        if (Auth::guard('admin')->user()->id == 1) {
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
        } else {
            return back()->withErrors(['error' => 'Only the super admin can add accounts']);
        }
    }

    public function destroy(Admin $admin)
    {
        if (Auth::guard('admin')->user()->id == 1) {
            if ($admin->id == 1) {
                return back()->withErrors(['error' => 'You cannot delete the super admin account.']);
            } else {
                Admin::destroy($admin->id);
                return redirect('/admin/dashboard/admins')->with('success', 'Account has been deleted!');
            }
        } else {
            return back()->withErrors(['error' => 'Only the super admin can delete accounts']);
        }
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
            'name' => 'required|min:5|max:255',
        ]);

        $admin = Auth::guard('admin')->user();
        $admin->update([
            'name' => $request->input('name')
        ]);

        return back()->with('success', 'Account updated!.');
    }

    public function updatePassword(Request $request)
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

            return back()->with('success', 'Password updated!.');
        } else {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    }
}
