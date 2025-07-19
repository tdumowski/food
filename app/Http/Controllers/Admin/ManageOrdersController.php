<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


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

    public function AllClientOrders() {
        $clientId = Auth::guard('client')->id();
        $orderItemGroupData = OrderItem::with(['product', 'order'])
            ->where('client_id', $clientId)
            ->orderBy('order_id', 'desc')
            ->get()
            ->groupBy('order_id');

        return view('client.backend.order.all_orders', compact('orderItemGroupData'));
    }

    public function ClientOrderDetails($orderId) {
        $order = Order::with('user')->where('id', $orderId)->first();
        $orderItems = OrderItem::with('product')->where("order_id", $orderId)->orderBy('id')->get();

        $totalPrice = 0;
        
        foreach($orderItems as $item) {
            $totalPrice += $item->price * $item->quantity;
        }

        return view('client.backend.order.client_order_details', compact('order', 'orderItems', 'totalPrice'));
    }

    public function ConfirmedOrders() {
        $orders = Order::where('status', 'CONFIRMED')->get();
        return view('admin.backend.order.confirmed_orders', compact('orders'));
    }

    public function DeliveredOrders() {
        $orders = Order::where('status', 'DELIVERED')->get();
        return view('admin.backend.order.delivered_orders', compact('orders'));
    }

    public function PendingOrders() {
        $orders = Order::where('status', 'PENDING')->get();
        return view('admin.backend.order.pending_orders', compact('orders'));
    }

    public function PendingToConfirm($id) {
        $order = Order::find($id);

        if($order) {
            $order->status = "CONFIRMED";
            $order->confirmed_date = Carbon::today()->format('Y-m-d');
            
            if($order->save()) {
                $notification = array(
                    "message" => "Order confirmed successfully", 
                    "alert-type" => "success"
                );
                return redirect()->route("confirmed.orders")->with($notification);
            }
            else {
                $notification = array(
                    "message" => "Order NOT confirmed, please try again", 
                    "alert-type" => "error"
                );
                return redirect()->back()->with($notification);
            }
        }
        else {
            $notification = array(
                "message" => "Order NOT FOUND", 
                "alert-type" => "error"
            );
            return redirect()->back()->with($notification);
        }
    }

    public function ConfirmToProcessing($id) {
        $order = Order::find($id);

        if($order) {
            $order->status = "PROCESSING";
            $order->processing_date = Carbon::today()->format('Y-m-d');
            
            if($order->save()) {
                $notification = array(
                    "message" => "Order processed successfully", 
                    "alert-type" => "success"
                );
                return redirect()->route("processing.orders")->with($notification);
            }
            else {
                $notification = array(
                    "message" => "Order NOT processed, please try again", 
                    "alert-type" => "error"
                );
                return redirect()->back()->with($notification);
            }
        }
        else {
            $notification = array(
                "message" => "Order NOT FOUND", 
                "alert-type" => "error"
            );
            return redirect()->back()->with($notification);
        }
    }

    public function ProcessingToDelivered($id) {
        $order = Order::find($id);

        if($order) {
            $order->status = "DELIVERED";
            $order->delivered_date = Carbon::today()->format('Y-m-d');
            
            if($order->save()) {
                $notification = array(
                    "message" => "Order delivered successfully", 
                    "alert-type" => "success"
                );
                return redirect()->route("delivered.orders")->with($notification);
            }
            else {
                $notification = array(
                    "message" => "Order NOT delivered, please try again", 
                    "alert-type" => "error"
                );
                return redirect()->back()->with($notification);
            }
        }
        else {
            $notification = array(
                "message" => "Order NOT FOUND", 
                "alert-type" => "error"
            );
            return redirect()->back()->with($notification);
        }
    }

    public function ProcessingOrders() {
        $orders = Order::where('status', 'PROCESSING')->get();
        return view('admin.backend.order.processing_orders', compact('orders'));
    }

    public function UserOrdersList() {
        $userId = Auth::user()->id;
        $orders = Order::where('user_id', $userId)->orderBy('id', 'desc')->get();
        return view('frontend.dashboard.order.order_list', compact('orders'));
    }

    public function UserOrderDetails($id) {
        $userId = Auth::user()->id;
        $order = Order::where([['id', $id],['user_id', $userId]])->first();
        $orderItems = OrderItem::with('product')->where("order_id", $id)->orderBy('id')->get();

        $totalPrice = 0;
        
        foreach($orderItems as $item) {
            $totalPrice += $item->price * $item->quantity;
        }

        return view('frontend.dashboard.order.order_details', compact('order', 'orderItems', 'totalPrice'));
    }

    public function UserInvoiceDownload($id) {
        $userId = Auth::user()->id;
        $order = Order::where([['id', $id],['user_id', $userId]])->first();
        $orderItems = OrderItem::with('product')->where("order_id", $id)->orderBy('id')->get();

        $totalPrice = 0;
        
        foreach($orderItems as $item) {
            $totalPrice += $item->price * $item->quantity;
        }

        $pdf = Pdf::loadView('frontend.dashboard.order.invoice_download', compact('order', 'orderItems', 'totalPrice'))
            ->setpaper('A4')
            ->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path()
            ]);

        return $pdf->download('invoice.pdf');
    }
}
