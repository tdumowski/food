<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\City;

class ClientController extends Controller
{
    public function ClientChangePassword()
    {
        $id = Auth::guard('client')->id;
        $profileData = Client::find($id);

        return view('client.client_change_password', compact('profileData'));
    }

    public function ClientDashboard()
    {
        return view('client.index');
    }

    public function ClientLogin()
    {
        return view('client.client_login');
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

    public function ClientLogout()
    {
        Auth::guard('client')->logout();
        return redirect()->route('client.login')->with('success', 'Logout successful');
    }
    
    public function ClientPasswordUpdate(Request $request)
    {
        $profileData = Auth::guard('client')->user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        if (!Hash::check($request->old_password, $profileData->password)) {
            $notification = array(
                "message" => "Old password is incorrect", 
                "alert-type" => "error"
            );

            return redirect()->back()->with($notification);
        }

        $profileData->password = Hash::make($request->new_password);
        $profileData->save();

        $notification = array(
            "message" => "Password updated successfully", 
            "alert-type" => "success"
        );

        return redirect()->back()->with($notification);
    }

    public function ClientProfile()
    {
        $id = Auth::guard('client')->id();

        $cities = City::all();

        $profileData = Client::find($id);

        return view('client.client_profile', compact('profileData', 'cities'));
    }

    public function ClientProfileStore(Request $request)
    {
        $client_id = Auth::guard('client')->id();
        $profileData = Client::find($client_id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $profileData->name = $request->name;
        $profileData->email = $request->email;
        $profileData->phone = $request->phone;
        $profileData->address = $request->address;
        $profileData->city_id = $request->city_id;
        $profileData->shop_info = $request->shop_info;

        if ($request->hasFile('photo')) {
            $oldPhotoPath = $profileData->photo;
            $file = $request->file('photo');
            $filename = $client_id . "-p-" . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/client_images'), $filename);
            $profileData->photo = $filename;

            if($oldPhotoPath && $oldPhotoPath !== $filename) {
                // Delete old photo if it exists
                $this->deleteOldImage($oldPhotoPath);
            }
        }

        if ($request->hasFile('cover_image')) {
            $oldPhotoPath = $profileData->cover_image;
            $file = $request->file('cover_image');
            $filename = $client_id . "-c-" . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/client_images'), $filename);
            $profileData->cover_image = $filename;

            if($oldPhotoPath && $oldPhotoPath !== $filename) {
                // Delete old photo if it exists
                $this->deleteOldImage($oldPhotoPath);
            }
        }

        $profileData->save();

        $notification = array(
            "message" => "Profile updated successfully", 
            "alert-type" => "success"
        );

        return redirect()->back()->with($notification);
    }

    public function ClientRegister()
    {
        return view('client.client_register');
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
    
    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/client_images/' . $oldPhotoPath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
