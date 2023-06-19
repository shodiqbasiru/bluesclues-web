<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return view('news', [
            'title' => 'News',
        ]);
    }

    public function show(News $news)
    {
        return view('news-detail', [
            "title" => "Detail News",
            "news" => $news
        ]);
    }
}
