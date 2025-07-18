<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        // $order->order_number = IdGenerator::generate(['table' => 'orders', 'field' => 'order_number', 'length' => 8, 'prefix' => 'order']);
        $order->order_date = Carbon::now()->format('Y-m-d');
        $order->order_month = Carbon::now()->format('F');
        $order->order_year = Carbon::now()->format('Y');
        $order->invoice_number = 'easyshop' . mt_rand(10000000,99999999);
        $order->status = 'PENDING';
        
        if($order->save()) {
            $orderId = $order->id;

            foreach($cart as $product) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $orderId;
                $orderItem->product_id = $product['id'];
                $orderItem->client_id = $product['client_id'];
                $orderItem->quantity = $product['quantity'];
                $orderItem->price = $product['price'];

                $orderItem->save();
            }

            if(Session::has('coupon')) {
                Session::forget('coupon');
            }
            
            if(Session::has('cart')) {
                Session::forget('cart');
            }

            $notification = array(
                "message" => "Order placed successfully", 
                "alert-type" => "success"
            );
            return view('frontend.checkout.thanks')->with($notification);

        }

    }
}
