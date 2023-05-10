<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index()
    {
        return view('song', ["title" => "Halaman Musik"]);
    }
}
