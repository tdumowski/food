<?php

namespace App\Http\Controllers;

// use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function Index()
    {
        return view('frontend.index');
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

        private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/user_images/' . $oldPhotoPath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
