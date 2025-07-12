<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function AddCoupon()
    {
        return view('client.backend.coupon.add_coupon');
    }
    
    public function AllCoupon()
    {
        $coupons = Coupon::orderBy('name')->get();

        return view('client.backend.coupon.all_coupon', compact('coupons'));
    }

    public function StoreCoupon(Request $request)
    {        
        $coupon = new Coupon();
        $coupon->name = strtoupper($request->name);
        $coupon->description = $request->description;
        $coupon->discount = $request->discount;
        $coupon->validity = $request->validity;
        $coupon->client_id = Auth::guard('client')->id();

        if($coupon->save()) {
            $notification = array(
                "message" => "Coupon added successfully", 
                "alert-type" => "success"
            );
            return redirect()->route('all.coupon')->with($notification);
        }
        
        $notification = array(
            "message" => "Coupon NOT added, please try again", 
            "alert-type" => "error"
        );
        return redirect()->back()->with($notification);
    }

}
