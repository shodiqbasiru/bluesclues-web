<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use App\Models\MerchCategory;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    // public $search;

    public function index()
    {
        // if ($this->search) {
        //     $products = MerchCategory::with('merchandises')->where('name', 'like', '%' . $this->search . '%')->paginate(8);
        // } else {

        //     $products = MerchCategory::with('merchandises')->paginate(8);
        // }

        // return $products;
        // return view('layouts.merchandise.main', [
        //     'title' => 'Merchandise',
        // ]);
    }

    // public function category()
    // {
    //     return view('layouts.merchandise.main', [
    //         "title" => "Detail Store",
    //     ]);
    // }
}
