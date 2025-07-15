<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Sesssion;
use App\Models\Product;

class CartController extends Controller
{
    public function AddToCart($product_id) {
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
            "message" => "Product adde to your cart", 
            "alert-type" => "success"
        );
        return redirect()->back()->with($notification);
    }
}
