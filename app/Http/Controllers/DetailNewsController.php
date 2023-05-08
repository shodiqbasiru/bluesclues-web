<?php

namespace App\Http\Controllers;

class DetailNewsController extends Controller
{
    public function index()
    {
        return view('news-detail', [
            'title' => 'Detail News'
        ]);
    }
}
