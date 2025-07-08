<?php

namespace App\Http\Controllers;

// use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/user_images/' . $oldPhotoPath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function Index()
    {
        return view('frontend.index');
    }

    public function UserChangePassword()
    {
        return view('frontend.dashboard.change_password');
    }

    public function UserLogout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully');
    }

    public function UserPasswordUpdate(Request $request)
    {
        $profileData = Auth::guard('web')->user();

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

        $profileData = User::find($profileData->id);
        $profileData->password = Hash::make($request->new_password);
        $profileData->save();

        $notification = array(
            "message" => "Password updated successfully", 
            "alert-type" => "success"
        );

        return redirect()->back()->with($notification);
    }

    public function UserProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $profileData->name = $request->name;
        $profileData->email = $request->email;
        $profileData->phone = $request->phone;
        $profileData->address = $request->address;
        $oldPhotoPath = $profileData->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/user_images'), $filename);
            $profileData->photo = $filename;

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
}
