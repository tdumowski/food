<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;
use App\Models\Product;
use Carbon\Carbon;

class CartController extends Controller
{
    public function AddToCart($product_id) {

        if(Session::has('coupon')) {
            Session::forget('coupon');
        }


        $product = Product::findOrFail($product_id);
        $cart = session()->get('cart', []);

        if(isset($cart[$product_id])) {
            $cart[$product_id]['quantity']++;
        }
        else {
            $priceToShow = isset($product->discount_price) ? $product->discount_price : $product->price;

            $cart[$product_id] = [
                'id' => $product_id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $priceToShow,
                'client_id' => $product->client->id,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);
        
        $notification = array(
            "message" => "Product added to your cart", 
            "alert-type" => "success"
        );
        return redirect()->back()->with($notification);
    }

    public function ApplyCoupon(Request $request) {
        $coupon = Coupon::where('name', $request->coupon_name)
            ->whereDate('validity', ">=", Carbon::today()->format('Y-m-d'))
            ->first();
        $cart = session()->get('cart', []);
        $totalAmount = 0;
        $clientIds = [];

        foreach($cart as $cartProduct) {
            $totalAmount += ($cartProduct['price'] * $cartProduct['quantity']);
            $product = Product::find($cartProduct['id']);
            $clientIds[] = $product->client->id;
        }

        if($coupon) {
            if(count(array_unique($clientIds)) == 1) {
                //order with product from only one restaurant
                $clientId = $coupon->client_id;
                
                if($clientId == $clientIds[0]) {
                    Session::put('coupon', [
                        'coupon_name' => $coupon->name,
                        'discount' => $coupon->discount,
                        'discount_amount' => $totalAmount - ($totalAmount * $coupon->discount/100),
                    ]);

                    $couponData = session()->get('coupon');

                    return response()->json(array(
                        'validity' => true,
                        'success' => 'Coupon appplieed successfully',
                        'couponData' => $couponData
                    ));
                }
                else {
                    return response()->json(['error' => 'This coupon is not valid for this restaurant']);
                }
            }
            else {
                return response()->json(['error' => '???']);
            }
        }
        else {
            return response()->json(['error' => 'Invalid coupon']);
        }
    }

    public function RemoveCoupon() {
        Session::forget('coupon');
        return response()->json(['success' => 'Coupon removed successfully']);
    }

    public function UpdateCartQuantity(Request $request) {
        $cart = session()->get('cart', []);

        if(isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return response()->json([
            'message' => 'Quantity updated',
            'alert-type' => 'success'
        ]);
    }

    public function RemoveFromCart(Request $request) {
        $cart = session()->get('cart', []);

        if(isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'message' => 'Product removed from your cart',
            'alert-type' => 'success'
        ]);
    }
}
