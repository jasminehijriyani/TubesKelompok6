<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'Akun dengan email tersebut belum terdaftar.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check if the authenticated user is an admin
            if (Auth::user()->is_admin) {
                // Redirect admin to the admin dashboard
                return redirect()->route('admin.dashboard');
            } else {
                // Redirect non-admin users (customers) to the public products page
                return redirect()->route('public.products.index');
            }
        }

        return back()->withErrors([
            'email' => 'Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page after logout
        return redirect()->route('login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:owner,customer'],
        ]);

        $user = User::create([ //Membuat user baru dengan data dari request, termasuk hashing password dan set is_admin jika role-nya 'owner'
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => ($request->role === 'owner'),
        ]);

        // Log the user in after registration
        Auth::login($user);

        // Redirect user based on their role after registration and login
        if (Auth::user()->is_admin) {
            // Redirect admin (Owner) to the admin dashboard
            return redirect()->route('admin.dashboard');
        } else {
            // Redirect non-admin users (Pelanggan) to the public products page
            return redirect()->route('public.products.index');
        }
    }
}
