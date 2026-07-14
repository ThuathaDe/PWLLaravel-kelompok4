<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    // Ganti password di bawah ini sesuai keinginan Anda
    private string $adminPassword = 'admin123';

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if ($request->password === $this->adminPassword) {
            session(['is_admin' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['password' => 'Password salah']);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');
        return redirect('/');
    }
}
