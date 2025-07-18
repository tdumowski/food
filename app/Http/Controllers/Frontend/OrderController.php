<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;


class OrderController extends Controller
{
    public function CashOrder(Request $request) {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $cart = Session()->get('cart', []);
        $totalAmount = 0;

        foreach($cart as $product) {
            $totalAmount += ($product['price'] * $product['quantity']);
        }

        if(Session::has('coupon')) {
             $tt = (Session()->get('coupon')['discount_amount']);
        }
        else {
            $tt = $totalAmount;
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->payment_type = 'Cash on delivery';
        $order->payment_method = 'Cash on delivery';
        $order->currency = "USD";
        $order->amount = $totalAmount;
        $order->total_amount = $tt;
        $order->invoice_number = 'easyshop' . mt_rand(10000000,99999999);
        $order->order_date = Carbon::now()->format('Y-m-d');
        $order->order_month = Carbon::now()->format('F');
        $order->order_year = Carbon::now()->format('Y');
        $order->invoice_number = 'easyshop' . mt_rand(10000000,99999999);
        $order->status = 'PENDING';
        
        if($order->save()) {
            $order_id = $order->id;
        }
        

    }
}
