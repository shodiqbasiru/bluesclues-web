<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\VideosController;

class Contents extends Component
{
    public $count = 9;
    public $videos = [];
    public $totalVideos;

    public function mount()
    {
        $this->loadVideos();
        $this->totalVideos = $this->getTotalVideosCount();;
    }

    public function getTotalVideosCount()
    {
        $videosController = new VideosController();
        $videosData = $videosController->index();
        return $videosData->count();
    }

    public function loadVideos()
    {
        $videosController = new VideosController();
        $videosData = $videosController->index();

        // Mengambil data berikutnya
        $this->videos = $videosData->take($this->count);
    }


    public function loadMore()
    {
        $this->count += 8;
        $this->loadVideos();
        sleep(1);
    }

    public function render()
    {
        return view('livewire.contents');
    }
}
