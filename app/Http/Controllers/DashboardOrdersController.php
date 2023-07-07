<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DashboardOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->input('status');



        if ($status === 'waiting-for-payment') {
            $orders_status = 1;
        } elseif ($status === 'checking-payment') {
            $orders_status = 2;
        } elseif ($status === 'success') {
            $orders_status = 3;
        } elseif ($status === 'cancelled') {
            $orders_status = 4;
        }

        if (empty($status)) {
            $orders = Order::with('orderDetails.merchandise')
                ->where('status', '!=', 0)
                ->orderByDesc('created_at');
        } else {
            $orders = Order::with('orderDetails.merchandise')
                ->where('status', $orders_status)
                ->orderByDesc('created_at');
        }

        // item number pagination
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $startIndex = ($currentPage - 1) * $perPage + 1;

        $orders = $orders->paginate($perPage)
            ->appends(['status' => $status]);
        return view('dashboard.orders.index', [
            'title' => 'Orders',
            'orders' => $orders,
            'status' => $status,
            'startIndex' => $startIndex,
        ]);
    }

    public function show(Order $order)
    {
        $order->load('orderDetails.merchandise', 'user');

        return view('dashboard.orders.show', [
            'title' => 'Order Details',
            'order' => $order,
        ]);
    }
}
