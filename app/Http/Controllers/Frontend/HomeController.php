<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Menu;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function RestaurantDetails($id)
    {
        $client = Client::findOrFail($id);
        $menus = Menu::where('client_id', $client->id)->get()->filter(function($menu) {
            // return $menu->name == "asd";
            return $menu->products->isNotEmpty();
        });
        return view('frontend.restaurant_details', compact('client', 'menus'));
    }
}
