<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Controllers\VideosController;

class HomeController extends Controller
{
    public function index()
    {

        $latestData = News::latest()->take(3)->get();
        $videosForHome = new VideosController();
        $videos = $videosForHome->index();

        return view('home', [
            'title' => 'Halaman Home',
            'news' => $latestData,
            'videos' => $videos
        ]);
    }
}
