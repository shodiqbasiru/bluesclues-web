<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->take(4)->get();

        return view('news', [
            'title' => 'News',
            'news' => $news
        ]);
    }

    // public function loadMore(Request $request)
    // {
    //     $skip = $request->skip;
    //     $news = News::latest()->skip($skip)->take(4)->get();
    //     return response()->json([
    //         'news' => $news,
    //         'html' => view('news', compact('news'))->render()
    //     ]);
    // }

    public function show(News $news)
    {
        return view('news-detail', [
            "title" => "Detail News",
            "news" => $news
        ]);
    }
}
