<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'spotify_link',
        'youtube_link',
        'release_date',
        'album',
        'lyrics',

    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
