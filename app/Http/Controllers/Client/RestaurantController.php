<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class RestaurantController extends Controller
{
    public function AddMenu()
    {
        return view('client.backend.menu.add_menu');
    }
    
    public function AllMenu()
    {
        $id = Auth::guard('client')->id();
        // $menus = Menu::where('client_id', $id)->orderBy('id', 'desc')->get();
        $menus = Menu::orderBy('id', 'desc')->get();

        return view('client.backend.menu.all_menu', compact('menus'));
    }
        
    public function StoreMenu(Request $request)
    {        
        if($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $save_url = 'upload/menu/'.$imageName;
            $img->resize(300, 300)->save(public_path($save_url));
            
            $menu = new Menu();
            $menu->name = $request->name;
            $menu->image = $save_url;
            $menu->save();
        }
        else {
            $menu = new Menu();
            $menu->name = $request->name;
            $menu->image = 'upload/no_image.jpg';
            $menu->save();
        }
        
        $notification = array(
            "message" => "Menu added successfully", 
            "alert-type" => "success"
        );
        return redirect()->route('all.menu')->with($notification);
    }

}
