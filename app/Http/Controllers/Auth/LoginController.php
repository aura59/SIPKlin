<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
       $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:admin,dokter'],
        ]);
        $remember = $request->boolean('remember');

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => $credentials['role'],
        ], $remember)) {

            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if (Auth::user()->role === 'dokter') {
                return redirect()->route('dokter.dashboard');
            }
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}