<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        return view('merchandise.store', [
            "title" => "Halaman Store"
        ]);
    }
}
