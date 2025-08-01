<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Gallery;
use App\Models\Menu;
use App\Models\Wishlist;
use App\Models\Review;
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

    public function RemoveWishlist($id) {
        if(Wishlist::find($id)->delete()) {
            $notification = array(
                "message" => "Restaurant removed from favorities successfully", 
                "alert-type" => "success"
            );
            return redirect()->back()->with($notification);
        }
                
        $notification = array(
            "message" => "Restaurant NOT removed from favorities, please try again", 
            "alert-type" => "error"
        );
        return redirect()->back()->with($notification);
    }

    public function RestaurantDetails($client_id)
    {
        $client = Client::findOrFail($client_id);
        
        $menus = Menu::where('client_id', $client->id)->get()->filter(function($menu) {
            return $menu->products->isNotEmpty();
        });
        
        $galleries = Gallery::where('client_id', $client->id)->get();

        $reviews = Review::where('client_id', $client->id)->where("status", 1)->get();
        $totalReviews = $reviews->count();
        $ratingSum = $reviews->sum('rating');
        $ratingAvg = ($totalReviews) > 0 ? round($ratingSum / $totalReviews, 1) : 0;
        
        $ratingCounts  =[
            '5' => $reviews->where('rating', 5)->count(),
            '4' => $reviews->where('rating', 4)->count(),
            '3' => $reviews->where('rating', 3)->count(),
            '2' => $reviews->where('rating', 2)->count(),
            '1' => $reviews->where('rating', 1)->count()
        ];

        $ratingPerecentages = array_map(function($count) use ($totalReviews) {
            return $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }, $ratingCounts);

        return view('frontend.restaurant_details', compact('client', 'menus', 'galleries', 'reviews', 'ratingAvg', 'totalReviews', 'ratingCounts', 'ratingPerecentages'));
    }
}
