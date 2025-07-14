<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function RestaurantDetails($id)
    {
        $client = \App\Models\Client::findOrFail($id);

        return view('frontend.restaurant_details', compact('client'));
    }
}
