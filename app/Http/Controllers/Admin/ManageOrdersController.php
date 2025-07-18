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
    public function AdminOrderDetails($id) {
        $order = Order::with('user')->where('id', $id)->first();
        $orderItems = OrderItem::with('product')->where("order_id", $id)->orderBy('id')->get();

        $totalPrice = 0;
        
        foreach($orderItems as $item) {
            $totalPrice += $item->price * $item->quantity;
        }

        return view('admin.backend.order.admin_order_details', compact('order', 'orderItems', 'totalPrice'));
    }

    public function ConfirmedOrders() {
        $orders = Order::where('status', 'CONFIRM')->get();
        return view('admin.backend.order.confirmed_order', compact('orders'));
    }

    public function DeliveredOrders() {
        $orders = Order::where('status', 'DELIVERED')->get();
        return view('admin.backend.order.delivered_order', compact('orders'));
    }

    public function PendingOrders() {
        $orders = Order::where('status', 'PENDING')->get();
        return view('admin.backend.order.pending_order', compact('orders'));
    }

    public function ProcessingOrders() {
        $orders = Order::where('status', 'PROCESSING')->get();
        return view('admin.backend.order.processing_order', compact('orders'));
    }
}
