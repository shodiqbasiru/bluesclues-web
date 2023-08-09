<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DashboardNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // item number pagination
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $startIndex = ($currentPage - 1) * $perPage + 1;

        $searchQuery = $request->input('search');
        $month = $request->input('month');
        $year = $request->input('year');
        $yearonly = $request->input('yearonly');


        $news = News::latest();

        if ($month && $year) {
            $dateString = $year . '-' . $month . '-01'; // Construct a date string with year, month, and day
            $news->whereMonth('created_at', Carbon::parse($dateString)->month)
                ->whereYear('created_at', $year);
        }

        if ($yearonly) {
            $news->whereYear('created_at', $yearonly);
        }

        if (!empty($searchQuery)) {
            $news->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', "%$searchQuery%");
            });
        }

        $news = $news->paginate($perPage)->appends([
            'search' => $searchQuery,
            'month' => $month,
            'year' => $year,
            'yearonly' => $yearonly,
        ]);

        return view('dashboard.news.index', [
            'title' => 'News',
            'news' => $news,
            'startIndex' => $startIndex,
            'searchQuery' => $searchQuery,
            'month' => $month,
            'selectedYear' => $year,
            'selectedYearOnly' => $yearonly,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.news.createNews', [
            'title' => 'News'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'image' => 'image|file|max:5120',
            'content' => 'required',
        ]);




        // create a new news article
        $news = new News;
        $news->title = $validatedData['title'];
        $news->content = $validatedData['content'];
        $news->excerpt = Str::limit(strip_tags($validatedData['content']), 200, '...');
        $news->excerpt = str_replace('&nbsp;', '', $news->excerpt);

        $truncatedTitle = substr($validatedData['title'], 0, 50);
        $slug = Str::slug($truncatedTitle, '-') . '-' . uniqid();
        while (News::where('slug', $slug)->exists()) {
            $slug = Str::slug($truncatedTitle, '-') . '-' . uniqid();
        }
        $news->slug = $slug;

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('news-images');
            $news->image = $validatedData['image'];
        }
        $news->save();

        // redirect back to the form with a success message
        return redirect('/admin/dashboard/news')->with('success', 'News article added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
        return view('dashboard.news.show', [
            'title' => 'News',
            'news' => $news
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
        return view('dashboard.news.edit', [
            'title' => 'News',
            'news' => $news
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'image' => 'image|file|max:7168',
            'content' => 'required',
        ]);

        // update the news article
        $news = News::find($news->id);
        $news->title = $validatedData['title'];
        $news->content = $validatedData['content'];
        $news->excerpt = Str::limit(strip_tags($validatedData['content']), 100, '...');
        $news->excerpt = str_replace('&nbsp;', '', $news->excerpt);

        $truncatedTitle = substr($validatedData['title'], 0, 50);
        $slug = Str::slug($truncatedTitle, '-') . '-' . uniqid();
        while (News::where('slug', $slug)->exists()) {
            $slug = Str::slug($truncatedTitle, '-') . '-' . uniqid();
        }
        if ($request->file('image')) {
            if ($news->image != null) Storage::delete($news->image);
            $validatedData['image'] = $request->file('image')->store('news-images');
            $news->image = $validatedData['image'];
        }
        $news->slug = $slug;
        $news->save();

        // redirect back to the form with a success message
        return redirect('/admin/dashboard/news')->with('success', 'News article has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
        if ($news->image != null) Storage::delete($news->image);
        News::destroy($news->id);
        return redirect('/admin/dashboard/news')->with('success', 'News article has been deleted!');
    }
}
