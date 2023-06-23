<?php

namespace App\Http\Livewire;

use App\Models\News;
use Livewire\Component;

class NewsContents extends Component
{
    public $count = 4;

    public function render()
    {
        $news = News::latest()->take($this->count)->get();
        $totalNews = News::count();

        return view('livewire.news-contents', [
            "news" => $news,
            "totalNews" => $totalNews,
        ]);
    }

    public function loadMore()
    {
        $this->count += 4;
        sleep(1);
    }
}
