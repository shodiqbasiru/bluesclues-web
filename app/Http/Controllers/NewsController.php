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

    public function show($slug)
    {

        $news = News::where('slug', $slug)->firstOrFail();
        $shareLinks = \Share::page(route('news.share', $news->slug), $news->title)
            ->facebook()
            ->telegram()
            ->twitter()
            ->whatsapp()
            ->getRawLinks();

        return view('news-detail', [
            "title" => "Detail News",
            "news" => $news,
            "shareLinks" => $shareLinks
        ]);
    }
}
