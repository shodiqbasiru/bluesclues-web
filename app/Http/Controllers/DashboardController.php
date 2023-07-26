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

        // Get the latest order's creation date
        $latestOrderDate = Order::where('status', '!=', 0)->latest('created_at')->value('created_at');
        $latestOrderDays = Carbon::parse($latestOrderDate)->diffInDays(Carbon::now());

        // Get the latest approval request's creation date
        $latestApprovalRequestDate = ShowRequest::where('status', 0)->latest('created_at')->value('created_at');
        $latestApprovalRequestDays = Carbon::parse($latestApprovalRequestDate)->diffInDays(Carbon::now());

        // Get the latest order's creation date
        $latestOrderDate = Order::where('status', '!=', 0)->latest('created_at')->value('created_at');
        $latestOrderDays = Carbon::parse($latestOrderDate)->diffInDays(Carbon::now());

        // Get the latest user's creation date
        $latestUserDate = User::latest('created_at')->value('created_at');
        $latestUserDays = Carbon::parse($latestUserDate)->diffInDays(Carbon::now());

        // Get the latest merchandise's creation date
        $latestMerchandiseDate = Merchandise::latest('created_at')->value('created_at');
        $latestMerchandiseDays = Carbon::parse($latestMerchandiseDate)->diffInDays(Carbon::now());

        // Get the latest news' creation date
        $latestNewsDate = News::latest('created_at')->value('created_at');
        $latestNewsDays = Carbon::parse($latestNewsDate)->diffInDays(Carbon::now());

        return view('dashboard.index', [
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'ordersToCheck' => $ordersToCheck,
            'awaitingApprovalRequests' => $awaitingApprovalRequests,
            'totalMerchandise' => $totalMerchandise,
            'totalNews' => $totalNews,
            'nearEvents' => $nearEvents,
            'latestApprovalRequestDays' => $latestApprovalRequestDays,
            'latestOrderDays' => $latestOrderDays,
            'latestUserDays' => $latestUserDays,
            'latestMerchandiseDays' => $latestMerchandiseDays,
            'latestNewsDays' => $latestNewsDays,

        ]);
    }
}
