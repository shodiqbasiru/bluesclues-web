<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;


class NewsController extends Controller
{
    //
    public function index()
    {
        return view('news', [
            'title' => 'News',
            'news' => News::latest()->get(),

        ]);
    }

    public function show(News $news)
    {
        return view('readNews', [
            'title' => 'News',
            'news' => $news
        ]);
    }

    public function select()
    {
        return response()->json([
            'news' => News::all()
        ], 201);

    }
}