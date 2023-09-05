<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;

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
        $searchQuery = $request->input('search');
        $month = $request->input('month');
        $year = $request->input('year');
        $yearonly = $request->input('yearonly');



        if ($status === 'waiting-for-payment') {
            $orders_status = 1;
        } elseif ($status === 'checking-payment') {
            $orders_status = 2;
        } elseif ($status === 'success') {
            $orders_status = 3;
        } elseif ($status === 'cancelled') {
            $orders_status = 4;
        } elseif ($status === 'shipping') {
            $orders_status = 5;
        } elseif ($status === 'product-received') {
            $orders_status = 6;
        }

        // Query builder for orders
        $orders = Order::with('orderDetails.merchandise')
            ->where('status', '!=', 0);

        // Apply search filter if a search query is provided
        if (!empty($searchQuery)) {
            $orders->where(function ($query) use ($searchQuery) {
                $query->where('order_number', 'like', "%$searchQuery%")
                    ->orWhere('name', 'like', "%$searchQuery%");
            });
        }

        // Get the total price of all orders
        $totalPrice = $orders->sum('total_price');

        // Apply status filter if selected
        if (!empty($status)) {
            $orders->where('status', $orders_status);
        }

        if ($month && $year) {
            $dateString = $year . '-' . $month . '-01'; // Construct a date string with year, month, and day
            $orders->whereMonth('created_at', Carbon::parse($dateString)->month)
                ->whereYear('created_at', $year);
        }
        if ($yearonly) {
            $orders->whereYear('created_at', $yearonly);
        }

        $orders->orderByDesc('created_at');

        // item number pagination
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $startIndex = ($currentPage - 1) * $perPage + 1;

        $orders = $orders->paginate($perPage)
            ->appends([
                'status' => $status,
                'search' => $searchQuery,
                'month' => $month,
                'year' => $year,
                'yearonly' => $yearonly,
            ]);
        return view('dashboard.orders.index', [
            'title' => 'Orders',
            'orders' => $orders,
            'status' => $status,
            'startIndex' => $startIndex,
            'searchQuery' => $searchQuery,
            'month' => $month,
            'selectedYear' => $year,
            'selectedYearOnly' => $yearonly,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function confirm(Order $order)
    {
        $order->update([
            'status' => 3,
        ]);

        return redirect()->back()->with('success', 'Order status has been updated!');
    }

    public function shipping(Order $order)
    {
        $order->update([
            'status' => 5,
        ]);

        return redirect()->back()->with('success', 'Order status has been updated!');
    }


    public function show(Order $order)
    {
        $order->load('orderDetails.merchandise', 'user');

        return view('dashboard.orders.show', [
            'title' => 'Order Details',
            'order' => $order,
        ]);
    }

    public function export(Request $request)
    {
        $status = $request->input('status');
        $month = $request->input('month');
        $year = $request->input('year');
        $yearonly = $request->input('yearonly');



        if ($status === 'waiting-for-payment') {
            $orders_status = 1;
        } elseif ($status === 'checking-payment') {
            $orders_status = 2;
        } elseif ($status === 'success') {
            $orders_status = 3;
        } elseif ($status === 'cancelled') {
            $orders_status = 4;
        } elseif ($status === 'shipping') {
            $orders_status = 5;
        } elseif ($status === 'product-received') {
            $orders_status = 6;
        }

        // Query builder for orders
        $orders = Order::with('orderDetails.merchandise')
            ->where('status', '!=', 0);

        $filename = 'orders-report';

        // Apply status filter if selected
        if (!empty($status)) {
            $orders->where('status', $orders_status);
            $filename .= '-status-' . $status;
        }

        if ($month && $year) {
            $dateString = $year . '-' . $month . '-01'; // Construct a date string with year, month, and day
            $orders->whereMonth('created_at', Carbon::parse($dateString)->month)
                ->whereYear('created_at', $year);
            $filename .= '-date-' . date('F', mktime(0, 0, 0, $month, 1)) . '-' . $year;
        }
        if ($yearonly) {
            $orders->whereYear('created_at', $yearonly);
            $filename .= '-date-' . $yearonly;
        }

        $orders->orderByDesc('created_at');

        $orders = $orders->get();

        $totalPrice = $orders->sum('total_price');

        $pdf = PDF::loadview('dashboard.orders.report', [
            'orders' => $orders,
            'status' => $status,
            'month' => $month,
            'selectedYear' => $year,
            'selectedYearOnly' => $yearonly,
            'totalPrice' => $totalPrice,
        ]);

        $filename = preg_replace('/[^a-zA-Z0-9\-]/', '_', $filename);

        return $pdf->stream($filename . '.pdf');
    }
}
