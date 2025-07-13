<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Banner;
use App\Models\Category;
use App\Models\City;
use App\Models\Client;
use App\Models\Gallery;
use App\Models\Menu;
use App\Models\Product;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class ManageController extends Controller
{
    public function AdminAddProduct()
    {
        $categories = Category::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $menus = Menu::orderBy('name')->get();
        return view('admin.backend.product.add_product', compact('categories', 'cities', 'menus', 'clients'));
    }

    public function AdminAllProduct()
    {
        $products = Product::orderBy('name')->get(); // <--- array of menu IDs used to filter products

        return view('admin.backend.product.all_product', compact('products'));
    }

    public function AdminDeleteProduct($id)
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

        return redirect()->route('admin.all.product')->with($notification);
    }
    
    public function AdminEditProduct($id)
    {
        $categories = Category::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $menus = Menu::orderBy('name')->get();
        $product = Product::findOrFail($id);

        return view('admin.backend.product.edit_product', compact('categories', 'cities', 'clients', 'menus', 'product'));
    }

    public function AdminStoreProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'client_id' => 'required',
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
        $product->client_id = $request->client_id;
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
            return redirect()->route('admin.all.product')->with($notification);
        }

        $notification = array(
            "message" => "Product NOT added, please try again", 
            "alert-type" => "error"
        );
        return redirect()->back()->with($notification);
    }

    public function AdminUpdateProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'menu_id' => 'required',
            'city_id' => 'required',
            'client_id' => 'required',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($request->id);
        $product->name = $request->name;
        $product->slug = strtolower(str_replace(' ', '-', $request->name));
        $product->client_id = $request->client_id;
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
            return redirect()->route('admin.all.product')->with($notification);
        }

        $notification = array(
            "message" => "Product NOT updated, please try again", 
            "alert-type" => "error"
        );
        return redirect()->back()->with($notification);
    }

    public function AllBanner()
    {
        $banners = Banner::orderBy('id', 'desc')->get();
        return view('admin.backend.banner.all_banner', compact('banners'));
    }

    public function ApprovedRestaurant()
    {
        $restaurants = Client::where('status', 1)->orderBy('name')->get();
        return view('admin.backend.restaurant.approved_restaurant', compact('restaurants'));
    }

    public function ClientChangeStatus(Request $request)
    {
        $client = Client::findOrFail($request->client_id);
        $client->status = $request->status;
        
        if ($client->save()) {
            return response()->json(['success' => 'Status changed successfully']);
        } else {
            return response()->json(['error' => 'Failed to change status']);
        }
    }

    public function PendingRestaurant()
    {
        $restaurants = Client::where('status', 0)->orderBy('name')->get();
        return view('admin.backend.restaurant.pending_restaurant', compact('restaurants'));
    }

    public function StoreBanner(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'url' => 'required|string',
        ]);

        $banner = new Banner();
        $banner->url = $request->url;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $save_url = 'upload/banner/'.$imageName;
            $img->resize(400, 400)->save(public_path($save_url));
            $banner->image = $save_url;
        }

        if ($banner->save()) {
            return redirect()->route('all.banner')->with('success', 'Banner added successfully');
        }

        return redirect()->back()->with('error', 'Failed to add banner');
    }
}
