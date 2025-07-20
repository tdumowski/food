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

    public function ClientAllReports() {
        return view('client.backend.report.all_report');
    }

    public function AdminSearchByDate(Request $request) {
        $date = new DateTime($request->date);
        $date = $date->format('Y-m-d');
        $orders = Order::where('order_date', $date)->latest()->get();

        return view('admin.backend.report.search_by_date', compact('date', 'orders'));
    }

    public function ClientSearchByDate(Request $request) {
        $date = new DateTime($request->date);
        $date = $date->format('Y-m-d');
        $clientId = Auth::guard('client')->id();
        $orders = Order::where('order_date', $date)->whereHas('OrderItem', function($query) use ($clientId) {
            $query->where('client_id', $clientId);
        })->latest()->get();

        $orderItemGroupData = OrderItem::with(['order','product'])
            ->whereIn('order_id', $orders->pluck('id'))
            ->where('client_id', $clientId)
            ->orderBy('order_id', 'desc')
            ->get()
            ->groupBy('order_id');

        return view('client.backend.report.search_by_date', compact('orderItemGroupData', 'date'));
    }

    public function AdminSearchByMonth(Request $request) {
        $month = $request->month_name;
        $year = $request->year_name;
        $orders = Order::where([['order_month', $month],['order_year', $year]])->latest()->get();

        return view('admin.backend.report.search_by_month', compact('month', 'year', 'orders'));
    }

    public function AdminSearchByYear(Request $request) {
        $year = $request->year;
        $orders = Order::where('order_year', $year)->latest()->get();

        return view('admin.backend.report.search_by_year', compact('year', 'orders'));
    }
}
