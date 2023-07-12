<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\ShowRequest;
use App\Models\Merchandise;
use App\Models\News;
use App\Models\Event;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total user count
        $totalUsers = User::count();

        // Get total order count (excluding orders with status 0)
        $totalOrders = Order::where('status', '!=', 0)->count();

        // Get orders that need to be checked (status 2)
        $ordersToCheck = Order::where('status', 2)->count();

        // Get awaiting approval show requests (status 0)
        $awaitingApprovalRequests = ShowRequest::where('status', 0)->count();

        // Get total merchandise count
        $totalMerchandise = Merchandise::count();

        // Get total news count
        $totalNews = News::count();

        // Get near events (within approximately 1 month)
        $nearEvents = Event::where('date', '>=', Carbon::now())
            ->where('date', '<=', Carbon::now()->addMonth())
            ->get();

        return view('dashboard.index', [
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'ordersToCheck' => $ordersToCheck,
            'awaitingApprovalRequests' => $awaitingApprovalRequests,
            'totalMerchandise' => $totalMerchandise,
            'totalNews' => $totalNews,
            'nearEvents' => $nearEvents,
        ]);
    }
}
