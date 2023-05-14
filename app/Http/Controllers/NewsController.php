<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);

        return view('news', [
            'title' => 'News',
            'news' => $news,
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
