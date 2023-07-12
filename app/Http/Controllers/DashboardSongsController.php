<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DashboardSongsController extends Controller
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

        $songs = Song::latest();

        if (!empty($searchQuery)) {
            $songs->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', "%$searchQuery%");
            });
        }

        $songs = $songs->paginate($perPage)->appends(['search' => $searchQuery]);

        return view('dashboard.songs.index', [
            'title' => 'Songs',
            'songs' => $songs,
            'startIndex' => $startIndex,
            'searchQuery' => $searchQuery,
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
        return view('dashboard.songs.addSong', [
            'title' => 'Songs'
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
            'image' => 'image|file|max:7168',
            'link' => 'required',
            'release_date' => 'required|date|after_or_equal:' . now()->subYears(30)->format('Y-m-d') . '|before_or_equal:' . now()->addYears(10)->format('Y-m-d'),
            'album' => 'required',
            'content' => 'required',

        ]);


        // add a new song
        $song = new Song;
        $song->title = $validatedData['title'];
        $song->link = $validatedData['link'];
        $song->release_date = $validatedData['release_date'];
        $song->album = $validatedData['album'];
        $song->lyrics = $validatedData['content'];

        $truncatedTitle = substr($validatedData['title'], 0, 50);
        $slug = Str::slug($truncatedTitle, '-') . '-' . uniqid();
        while (song::where('slug', $slug)->exists()) {
            $slug = Str::slug($truncatedTitle, '-') . '-' . uniqid();
        }
        $song->slug = $slug;
        if($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('songs-images');
            $song->image = $validatedData['image'];
        }
        $song->save();

        // redirect back to the form with a success message
        return redirect('/admin/dashboard/songs')->with('success', 'Song added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function show(Song $song)
    {
        //
        return view('dashboard.songs.show', [
            'title' => 'Songs',
            'song' => $song
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song)
    {
        //
        // Format the release date value using Carbon
        $formattedReleaseDate = Carbon::parse($song->release_date)->format('Y-m-d');
        return view('dashboard.songs.edit', [
            'title' => 'Songs',
            'song' => $song,
            'formattedReleaseDate' => $formattedReleaseDate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Song $song)
    {
        //
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'image' => 'image|max:7168',
            'link' => 'required',
            'release_date' => 'required|date|after_or_equal:' . now()->subYears(30)->format('Y-m-d') . '|before_or_equal:' . now()->addYears(10)->format('Y-m-d'),
            'album' => 'required',
            'content' => 'required',

        ]);


        // edit song
        $song = Song::find($song->id);
        $song->title = $validatedData['title'];
        $song->link = $validatedData['link'];
        $song->release_date = $validatedData['release_date'];
        $song->album = $validatedData['album'];
        $song->lyrics = $validatedData['content'];

        $truncatedTitle = substr($validatedData['title'], 0, 50);
        $slug = Str::slug($truncatedTitle, '-') . '-' . uniqid();
        while (song::where('slug', $slug)->exists()) {
            $slug = Str::slug($truncatedTitle, '-') . '-' . uniqid();
        }
        if($request->file('image')){
            if ($song->image != null) Storage::delete($song->image);
            $validatedData['image'] = $request->file('image')->store('songs-images');
            $song->image = $validatedData['image'];
        }
        $song->slug = $slug;
        $song->save();

        // redirect back to the form with a success message
        return redirect('/admin/dashboard/songs')->with('success', 'Song has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        //
        if ($song->image != null) Storage::delete($song->image);
        Song::destroy($song->id);
        return redirect('/admin/dashboard/songs')->with('success', 'Song has been deleted!');
    }
}
