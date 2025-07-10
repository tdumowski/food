<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Category;
use App\Models\City;


class RestaurantController extends Controller
{
    public function AddMenu()
    {
        return view('client.backend.menu.add_menu');
    }
    
    public function AddProduct()
    {
        $categories = Category::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $menus = Menu::orderBy('name')->get();
        return view('client.backend.product.add_product', compact('categories', 'cities', 'menus'));
    }
    
    public function AllMenu()
    {
        $id = Auth::guard('client')->id();
        // $menus = Menu::where('client_id', $id)->orderBy('id', 'desc')->get();
        $menus = Menu::orderBy('id', 'desc')->get();

        return view('client.backend.menu.all_menu', compact('menus'));
    }
    
    public function AllProduct()
    {
        $id = Auth::guard('client')->id();
        // $menus = Menu::where('client_id', $id)->orderBy('id', 'desc')->get();
        $products = Product::orderBy('id', 'desc')->get();

        return view('client.backend.product.all_product', compact('products'));
    }

    public function DeleteMenu($id)
    {
        $menu = Menu::findOrFail($id);
        
        if ($menu) {
            if ($menu->image != 'upload/no_image.jpg') {
                unlink(public_path($menu->image));
            }
            $menu->delete();
            
            $notification = array(
                "message" => "Menu deleted successfully", 
                "alert-type" => "success"
            );
        }
        else {
            $notification = array(
                "message" => "Menu not found", 
                "alert-type" => "error"
            );
        }

        return redirect()->route('all.menu')->with($notification);
    }

    public function EditMenu($id)
    {
        $menu = menu::findOrFail($id);
        return view('client.backend.menu.edit_menu', compact('menu'));
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

    public function UpdateMenu(Request $request)
    {
        $menu = Menu::findOrFail($request->id);
        
        if($menu) {
            if($request->file('image')) {
                $image = $request->file('image');
                $manager = new ImageManager(new Driver());
                $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $img = $manager->read($image);
                $save_url = 'upload/menu/'.$imageName;
                $img->resize(300, 300)->save(public_path($save_url));
                
                // Delete old image
                if ($menu->image != 'upload/no_image.jpg') {
                    unlink(public_path($menu->image));
                }
                
                $menu->image = $save_url;
            }

            $menu->name = $request->name;
            $menu->save();
            
            $notification = array(
                "message" => "Menu updated successfully", 
                "alert-type" => "success"
            );
            return redirect()->route('all.menu')->with($notification);
        }
        else {
            $notification = array(
                "message" => "Category not found", 
                "alert-type" => "error"
            );
            return redirect()->route('all.category')->with($notification);
        }
    }

}
