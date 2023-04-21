<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardSongsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dashboard.songs.index', [
            'title' => 'Songs',
            'news' => Song::latest()->get(),
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
            'spotify_link' => 'required',
            'youtube_link' => 'required',
            'release_date' => 'required|date',
            'album' => 'required',
            'content' => 'required',

        ]);


        // add a new song
        $song = new Song;
        $song->title = $validatedData['title'];
        $song->spotify_link = $validatedData['spotify_link'];
        $song->youtube_link = $validatedData['youtube_link'];
        $song->release_date = $validatedData['release_date'];
        $song->album = $validatedData['album'];
        $song->lyrics = $validatedData['content'];

        $truncatedTitle = substr($validatedData['title'], 0, 50);
        $slug = Str::slug($truncatedTitle, '-') . '-' . uniqid();
        while (song::where('slug', $slug)->exists()) {
            $slug = Str::slug($truncatedTitle, '-') . '-' . uniqid();
        }
        $song->slug = $slug;
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
    }
}
