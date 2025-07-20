<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReviewController extends Controller
{
    public function StoreReview(Request $request) {
        $clientId = $request->client_id;
        $request->validate([
            'comment' => 'required'
        ]);

        $review = new Review();
        $review->client_id = $clientId;
        $review->user_id = Auth::id();
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        
        $review->save();

        $notification = array(
            "message" => "Review will be approved by admin", 
            "alert-type" => "success"
        );

        $previousUrl = $request->headers->get('referer');
        $redirectUrl = $previousUrl ? $previousUrl . '#pills-reviews' : route('restaurant.details', ['id' => $clientId]) . '#pills-reviews';

        return redirect($redirectUrl)->with($notification);

    }
}
