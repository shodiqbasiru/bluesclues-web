<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'viewers',
        'published_at'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function increaseViewers()
    {
        $this->viewers = $this->viewers + 1;
        $this->save();
    }
}
