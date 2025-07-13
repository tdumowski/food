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
        $menus = Menu::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();
        return view('admin.backend.product.add_product', compact('categories', 'cities', 'menus', 'clients'));
    }

    public function AdminAllProduct()
    {
        $products = Product::orderBy('name')->get(); // <--- array of menu IDs used to filter products

        return view('admin.backend.product.all_product', compact('products'));
    }

}
