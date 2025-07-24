<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderItem;
use App\Notifications\OrderComplete;
use Carbon\Carbon;



class OrderController extends Controller
{
    public function CashOrder(Request $request) {

        $admin = Admin::where('role', 'admin')->get();

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

            Notification::send($admin, new OrderComplete($request->name));

            $notification = array(
                "message" => "Order placed successfully", 
                "alert-type" => "success"
            );
            return view('frontend.checkout.thanks')->with($notification);
        }
    }

    public function MarkAsRead(Request $request, $id) {
        $notification = Auth::guard('admin')->user()->notifications()->find($id);
        
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    public function StripeOrder(Request $request) {
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

        \Stripe\Stripe::setApiKey('sk_test_51RncVGPJr6sFH5YYWMUewPMGdarkvVnJ6uTrtrgD6ynikeb91pYQcQA0mECyTI7VM752KAc7QBlJD5ssd7PRqxI500P8YkzyLy');

        $token = $_POST['stripeToken'];

        $charge = \Stripe\Charge::create([
            'amount' => $totalAmount * 100,
            'currency' => 'usd',
            'description' => 'EasyFood Delivery',
            'source' => $token,
            'metadata' => ['order_id' => '6735']
        ]);

        $order = new Order();
        $order->user_id = Auth::id();
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->payment_type = $charge->payment_method;
        $order->payment_method = 'Stripe';
        $order->transaction_id = $charge->balance_transaction;
        $order->currency = $charge->currency;
        $order->amount = $totalAmount;
        $order->total_amount = $tt;
        $order->order_number = $charge->metadata->order_id;
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
