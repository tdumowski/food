<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Gallery;
use App\Models\Menu;
use App\Models\Wishlist;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function RestaurantDetails($id)
    {
        $client = Client::findOrFail($id);
        $menus = Menu::where('client_id', $client->id)->get()->filter(function($menu) {
            return $menu->products->isNotEmpty();
        });
        $galleries = Gallery::where('client_id', $client->id)->get();
        return view('frontend.restaurant_details', compact('client', 'menus', 'galleries'));
    }
}
