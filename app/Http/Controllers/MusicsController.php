<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;

class MusicsController extends Controller
{
    public function index()
    {
        $songs = Song::all();
        return view('music', [
            'title' => 'Halaman Musik',
            'music' => $songs
        ]);
    }

    public function show(Song $song)
    {
        $songs = Song::all();
        return view('music-detail', [
            "title" => "Detail News",
            "song" => $song,
            "songs" => $songs
        ]);
    }
}
