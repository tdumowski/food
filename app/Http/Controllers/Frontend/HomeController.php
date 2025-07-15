<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Gallery;
use App\Models\Menu;
use App\Models\Wishlist;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function AddWishlist(Request $request, $client_id) {
        //check if the user is logged
        if(!Auth::check()) {
            return response()->json(['error' => "Please login you account"]);
        }

        //check if the restaurant is already saved in user's wishlist
        $exists = Wishlist::where('user_id', Auth::id())->where('client_id', $client_id)->first();

        if($exists) {
            return response()->json(['error' => "This restaurant is already in your wishlist"]);
        }

        //add restaurant to wishlist
        $wishlist = new Wishlist();
        $wishlist->user_id = Auth::id();
        $wishlist->client_id = $client_id;
        
        if($wishlist->save()) {
            return response()->json(['success' => "Restaurant added to wishlist"]);
            
        }
    }

    public function AllWishlist() {
        $wishlists = Wishlist::where('user_id', Auth::id())->get();
        return view('frontend.dashboard.all_wishlist', compact('wishlists'));
    }

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
