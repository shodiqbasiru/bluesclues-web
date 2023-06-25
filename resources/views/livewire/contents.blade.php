<div class="body">
    <div class="videos">

        @foreach ($videos as $key => $video)
            @if ($key === 0)
                @continue
            @endif
            <div class="video">
                <img src="{{ $video['thumbnail'] }}" alt="{{ $video['title'] }}" class="video-thumbnail">
                <div class="overlay" data-video-id="{{ $video['id'] }}" id="thumbnail_{{ $video['id'] }}">
                    <h5 class="mt-5">{{ $video['title'] }}</h5>
                    <h5>Watch</h5>
                </div>
            </div>
        @endforeach
    </div>
    @if (count($videos) < $totalVideos)
        <button class="btn btn-home text-center" wire:click="loadMore">Load More</button>
    @endif
    <span class="loading" wire:loading>
        <div class="loading-spinner"></div>
    </span>

</div>