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
}
