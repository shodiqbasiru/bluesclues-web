<?php

namespace App\Http\Controllers;

use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {

        $latestData = News::latest()->take(3)->get();

        return view('home', [
            'title' => 'Halaman Home',
            'news' => $latestData

        ]);
    }
}
