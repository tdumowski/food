<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReviewController extends Controller
{
    public function AdminApprovedReviews() {
        $reviews = Review::where('status', 1)->orderBy('id', 'desc')->get();

        return view('admin.backend.review.view_approved_reviews', compact('reviews'));
    }

    public function AdminPendingReviews() {
        $reviews = Review::where('status', 0)->orderBy('id', 'desc')->get();

        return view('admin.backend.review.view_pending_reviews', compact('reviews'));
    }

    public function ClientAllReviews() {
        $clientId = Auth::guard('client')->id();
        $reviews = Review::where('status', 1)->where('client_id', $clientId)->orderBy('id', 'desc')->get();

        return view('client.backend.review.view_all_reviews', compact('reviews'));
    }
    
    public function ReviewChangeStatus(Request $request)
    {
        $review = Review::findOrFail($request->review_id);
        $review->status = $request->status;
        
        if ($review->save()) {
            return response()->json(['success' => 'Status changed successfully']);
        } else {
            return response()->json(['error' => 'Failed to change status']);
        }
    }

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
