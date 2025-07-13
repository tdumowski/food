<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Category;
use App\Models\City;
use App\Models\Client;
use App\Models\Gallery;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class ManageController extends Controller
{
    public function AdminAddProduct()
    {
        $categories = Category::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();
        $menus = Menu::orderBy('name')->get();
        return view('admin.backend.product.add_product', compact('categories', 'cities', 'menus', 'clients'));
    }

    public function AdminAllProduct()
    {
        $products = Product::orderBy('name')->get(); // <--- array of menu IDs used to filter products

        return view('admin.backend.product.all_product', compact('products'));
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

}
