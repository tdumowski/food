<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\Websitemail;
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
}
