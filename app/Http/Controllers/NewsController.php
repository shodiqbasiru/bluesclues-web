<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

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

        $viewedNews = Session::get('viewed_news', []);

        if (!in_array($news->id, $viewedNews)) {
            $news->increaseViewers();
            $viewedNews[] = $news->id;
            Session::put('viewed_news', $viewedNews);
        }

        $shareLinks = \Share::page(route('news.share', $news->slug), $news->title)
            ->facebook()
            ->telegram()
            ->twitter()
            ->whatsapp()
            ->getRawLinks();

        return view('news-detail', [
            "title" => "Detail News",
            "news" => $news,
            "shareLinks" => $shareLinks,
        ]);
    }
}
