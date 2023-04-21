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

    public function createNews()
    {
        return view('dashboard.news.createNews', [
            'title' => 'News'
        ]);
    }

    public function store(Request $request)
    {
        // validate the form data
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
        

        // create a new news article
        $news = new News;
        $news->title = $request->title;
        $news->content = $request->content;
        $news->slug = Str::slug($request->title, '-');
        $news->excerpt = Str::limit(strip_tags($request->content), 100, '...');
        $news->excerpt = str_replace('&nbsp;', '', $news->excerpt);
        $news->save();

        // redirect back to the form with a success message
        return redirect()->back()->with('success', 'News article added successfully!');
    }

    public function select()
    {
        return response()->json([
            'news' => News::all()
        ], 201);

    }
}