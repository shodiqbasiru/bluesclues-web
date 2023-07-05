<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchandise;
use App\Models\MerchCategory;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;


class StoreController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        $merchandise = Merchandise::with('merchCategory')->latest();
        $merchCategories = MerchCategory::all();

        if ($categorySlug) {
            // Filter the merchandise based on the selected category slug
            $merchandise->whereHas('merchCategory', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            });
        }

        $merchandise = $merchandise->get();

        return view('merchandise.store', [
            "title" => "Halaman Store",
            "merchandise" => $merchandise,
            "merchCategories" => $merchCategories,
        ]);
    }



    public function detail(Merchandise $merchandise)
    {

        return view('merchandise.detailStore', [
            "title" => "Detail Store",
            "merchandise" => $merchandise,
        ]);
    }
}
