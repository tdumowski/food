<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use DateTime;


class ReportController extends Controller
{
    public function AdminAllReports() {
        return view('admin.backend.report.all_report');
    }

    public function AdminSearchByDate(Request $request) {
        $date = new DateTime($request->date);
        $date = $date->format('Y-m-d');
        $orders = Order::where('order_date', $date)->latest()->get();

        return view('admin.backend.report.search_by_date', compact('date', 'orders'));
    }
}
