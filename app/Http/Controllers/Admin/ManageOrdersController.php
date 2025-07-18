<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;


class ManageOrdersController extends Controller
{
    public function PendingOrders() {
        $orders = Order::where('status', 'PENDING')->get();
        return view('admin.backend.order.pending_order', compact('orders'));
    }
}
