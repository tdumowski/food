<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;

class ClientController extends Controller
{
    public function ClientLogin()
    {
        return view('client.client_login');
    }

    public function ClientRegister()
    {
        return view('client.client_register');
    }

    public function ClientLoginSubmit(Request $request)
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

        if(Auth::guard('client')->attempt($data)) {
            return redirect()->route('client.dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->route('client.login')->with('error', 'Invalid credentials');
        }
    }

    public function ClientRegisterSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->password = Hash::make($request->password);
        $client->role = "client";
        $client->status = 0;
        $client->save();

        $notification = array(
            "message" => "Client registered successfully", 
            "alert-type" => "success"
        );

        return redirect()->route("client.login")->with($notification);
    }

    public function ClientDashboard()
    {
        return view('client.client_dashboard');
    }
}
