<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function AdminLogin()
    {
        return view('admin.login');
    }

    public function AdminDashboard()
    {
        return view('admin.admin_dashboard');
    }

    public function AdminLoginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];

        if(Auth::guard('admin')->attempt($data)) {
            return redirect()->route('admin.dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->route('admin.login')->with('error', 'Invalid credentials');
            // return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logout successful');
    }

    public function AdminForgetPassword()
    {
        return view('admin.forget_password');
    }

    public function AdminPasswordSubmit(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Here you would typically handle the password reset logic, such as sending a reset link to the email.
        // For simplicity, we'll just return a success message.
        
        return redirect()->route('admin.login')->with('success', 'Password reset link sent to your email.');
        // In a real application, you would send an email with a password reset link.
        // return redirect()->back()->with('success', 'Password reset link sent to your email
    }
}
