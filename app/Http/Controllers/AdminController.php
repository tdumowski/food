<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\Websitemail;
use App\Models\Admin;

class AdminController extends Controller
{
    public function AdminLogin()
    {
        return view('admin.login');
    }

    public function AdminDashboard()
    {
        return view('admin.index');
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

        $admin_data = Admin::where('email', $request->email)->first();

        if (!$admin_data) {
            return redirect()->back()->with('error', 'Email not found');
        }
        
        $token = hash("sha256", time());

        $admin_data->token = $token;
        $admin_data->update();

        $reset_link = url('/admin/reset_password/' . $token . '/' . $request->email);

        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password:<br>";
        $message .= "<a href='" . $reset_link . "'>Click here</a>";

        Mail::to($request->email)->send(new Websitemail($subject, $message));

        return redirect()->back()->with('success', 'Password reset link sent to your email.');
    }

    public function AdminResetPassword($token, $email)
    {
        $admin_data = Admin::where('token', $token)->where('email', $email)->first();

        if (!$admin_data) {
            return redirect()->route('admin.login')->with('error', 'Invalid token or email');
        }

        return view('admin.reset_password', compact('token', 'email'));
    }

    public function AdminResetPasswordSubmit(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        $admin_data = Admin::where('token', $request->token)->where('email', $request->email)->first();

        if (!$admin_data) {
            return redirect()->route('admin.login')->with('error', 'Invalid token or email');
        }

        $admin_data->password = Hash::make($request->password);
        $admin_data->token = null; // Clear the token after password reset
        $admin_data->update();

        return redirect()->route('admin.login')->with('success', 'Password reset successful. You can now login.');
    }
}
