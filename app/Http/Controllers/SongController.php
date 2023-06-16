<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function index()
    {
        return view('music', [
            "title" => "Halaman Musik",
        ]);
    }
}
