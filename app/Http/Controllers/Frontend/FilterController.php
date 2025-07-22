<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use Carbon\Carbon;

class FilterController extends Controller
{
    public function ListRestaurants() {
        $products = Product::all();
        return view('frontend.list_restaurants', compact('products'));
    }

    public function FilterProducts(Request $request) {

        // Log::info('request data: ', $request->all());

        $categoryIds = $request->input('category');
        $cityIds = $request->input('city');
        $menuIds= $request->input('menu');

        $products = Product::query();

        if($categoryIds) {
            $products->whereIn('category_id', $categoryIds);
        }
        if($menuIds) {
            $products->whereIn('menu_id', $menuIds);
        }
        if($cityIds) {
            $products->whereIn('city_id', $cityIds);
        }

        $products = $products->get();

        return view('frontend.product_list', compact('products'))->render();
    }
}
