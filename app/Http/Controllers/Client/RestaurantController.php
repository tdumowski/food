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
use App\Models\Gallery;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class RestaurantController extends Controller
{
    public function AddGallery()
    {
        return view('client.backend.gallery.add_gallery');
    }
    
    public function AddMenu()
    {
        return view('client.backend.menu.add_menu');
    }
    
    public function AddProduct()
    {
        $client_id = Auth::guard('client')->id();
        $categories = Category::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $menus = Menu::where('client_id', $client_id)->orderBy('name')->get();
        return view('client.backend.product.add_product', compact('categories', 'cities', 'menus'));
    }
    
    public function AllGallery()
    {
        $client_id = Auth::guard('client')->id();
        $galleries = Gallery::where('client_id', $client_id)->orderBy('id')->get();

        return view('client.backend.gallery.all_gallery', compact('galleries'));
    }
    
    public function AllMenu()
    {
        $client_id = Auth::guard('client')->id();
        $menus = Menu::where('client_id', $client_id)->orderBy('name')->get();

        return view('client.backend.menu.all_menu', compact('menus'));
    }
    
    public function AllProduct()
    {
        $client_id = Auth::guard('client')->id(); // <--- get the client ID
        $menus_id = Menu::where('client_id', $client_id)->pluck('id'); // <--- returns an array of menu IDs for the client
        $products = Product::whereIn('menu_id', $menus_id)->orderBy('name')->get(); // <--- array of menu IDs used to filter products

        return view('client.backend.product.all_product', compact('products'));
    }

    public function ChangeStatus(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $product->status = $request->status;
        
        if ($product->save()) {
            return response()->json(['success' => 'Status changed successfully']);
        } else {
            return response()->json(['error' => 'Failed to change status']);
        }
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

    public function DeleteGallery($id)
    {
        $gallery = Gallery::findOrFail($id);
        
        if ($gallery) {
            if ($gallery->image != 'upload/no_image.jpg') {
                unlink(public_path($gallery->image));
            }
            $gallery->delete();
            
            $notification = array(
                "message" => "Gallery deleted successfully", 
                "alert-type" => "success"
            );
        }
        else {
            $notification = array(
                "message" => "Gallery not found", 
                "alert-type" => "error"
            );
        }

        return redirect()->route('all.gallery')->with($notification);
    }

    public function DeleteProduct($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product) {
            if ($product->image != 'upload/no_image.jpg') {
                unlink(public_path($product->image));
            }

            if($product->delete()) {
                $notification = array(
                    "message" => "Product deleted successfully", 
                    "alert-type" => "success"
                );
            }
            else {
                $notification = array(
                    "message" => "Product NOT deleted, please try again", 
                    "alert-type" => "success"
                );
            }
        }
        else {
            $notification = array(
                "message" => "Menu not found", 
                "alert-type" => "error"
            );
        }

        return redirect()->route('all.product')->with($notification);
    }

    public function EditGallery($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('client.backend.gallery.edit_gallery', compact('gallery'));
    }

    public function EditMenu($id)
    {
        $menu = Menu::findOrFail($id);
        return view('client.backend.menu.edit_menu', compact('menu'));
    }
    
    public function EditProduct($id)
    {
        $client_id = Auth::guard('client')->id();
        $categories = Category::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $menus = Menu::where('client_id', $client_id)->orderBy('name')->get();
        $product = Product::findOrFail($id);

        return view('client.backend.product.edit_product', compact('categories', 'cities', 'menus', 'product'));
    }

    public function StoreGallery(Request $request)
    {        
        $images = $request->file('images');

        foreach($images as $key => $image) {
            $manager = new ImageManager(new Driver());
            $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $save_url = 'upload/gallery/'.$imageName;
            $img->resize(800, 800)->save(public_path($save_url));
   
            $gallery = new Gallery();
            $gallery->client_id = Auth::guard('client')->id();
            $gallery->image = $save_url;
            $gallery->save();
        }
        
        $notification = array(
            "message" => "Gallery added successfully", 
            "alert-type" => "success"
        );
        return redirect()->route('all.gallery')->with($notification);
    }

    public function StoreMenu(Request $request)
    {        
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->image = 'upload/no_image.jpg';
        $menu->client_id = Auth::guard('client')->id();

        if($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $save_url = 'upload/menu/'.$imageName;
            $img->resize(300, 300)->save(public_path($save_url));
            
            $menu->image = $save_url;
        }

        if($menu->save()) {
            $notification = array(
                "message" => "Menu added successfully", 
                "alert-type" => "success"
            );
            return redirect()->route('all.menu')->with($notification);
        }
        
        $notification = array(
            "message" => "Menu NOT added, please try again", 
            "alert-type" => "error"
        );
        return redirect()->back()->with($notification);
    }

    public function StoreProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'category_id' => 'required',
            'menu_id' => 'required',
            'city_id' => 'required',
            'price' => 'required|numeric',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = strtolower(str_replace(' ', '-', $request->name));
        $product->category_id = $request->category_id;
        $product->city_id = $request->city_id;
        $product->menu_id = $request->menu_id;
        $product->code = IdGenerator::generate(['table' => 'products', 'field' => 'code', 'length' => 5, 'prefix' => 'PC']);
        $product->qty = $request->qty;
        $product->size = $request->size;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->image = 'upload/no_image.jpg';
        $product->client_id = Auth::guard('client')->id();
        $product->most_popular = $request->most_popular;
        $product->best_seller = $request->best_seller;
        $product->status = 1;

        if($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $save_url = 'upload/product/'.$imageName;
            $img->resize(300, 300)->save(public_path($save_url));
            $product->image = $save_url;
        }

        if($product->save()) {
            $notification = array(
                "message" => "Product added successfully", 
                "alert-type" => "success"
            );
            return redirect()->route('all.product')->with($notification);
        }

        $notification = array(
            "message" => "Product NOT added, please try again", 
            "alert-type" => "error"
        );
        return redirect()->back()->with($notification);
    }

    public function UpdateGallery(Request $request)
    {
        $gallery = Gallery::findOrFail($request->id);
        
        if($gallery) {
            if($request->file('image')) {
                $image = $request->file('image');
                $manager = new ImageManager(new Driver());
                $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $img = $manager->read($image);
                $save_url = 'upload/gallery/'.$imageName;
                $img->resize(800, 800)->save(public_path($save_url));
                
                // Delete old image
                if ($gallery->image != 'upload/no_image.jpg') {
                    unlink(public_path($gallery->image));
                }
                
                $gallery->image = $save_url;

                $gallery->save();
                
                $notification = array(
                    "message" => "Gallery image updated successfully", 
                    "alert-type" => "success"
                );
                return redirect()->route('all.gallery')->with($notification);
            }
            else {
                $notification = array(
                    "message" => "Please select image file for update", 
                    "alert-type" => "warning"
                );
                return redirect()->back()->with($notification);

            }

        }
        else {
            $notification = array(
                "message" => "Gallery not found", 
                "alert-type" => "error"
            );
            return redirect()->back()->with($notification);
        }
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

    public function UpdateProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'menu_id' => 'required',
            'city_id' => 'required',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($request->id);
        $product->name = $request->name;
        $product->slug = strtolower(str_replace(' ', '-', $request->name));
        $product->category_id = $request->category_id;
        $product->city_id = $request->city_id;
        $product->menu_id = $request->menu_id;
        $product->qty = $request->qty;
        $product->size = $request->size;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->most_popular = $request->most_popular;
        $product->best_seller = $request->best_seller;

        if($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $save_url = 'upload/product/'.$imageName;
            $img->resize(300, 300)->save(public_path($save_url));

            // Delete old image
            if ($product->image != 'upload/no_image.jpg') {
                unlink(public_path($product->image));
            }

            $product->image = $save_url;
        }

        if($product->save()) {
            $notification = array(
                "message" => "Product updated successfully", 
                "alert-type" => "success"
            );
            return redirect()->route('all.product')->with($notification);
        }

        $notification = array(
            "message" => "Product NOT updated, please try again", 
            "alert-type" => "error"
        );
        return redirect()->back()->with($notification);
    }

}
