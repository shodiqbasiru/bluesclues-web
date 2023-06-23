<div class="content">
    <div class="news" id="news">


        @foreach ($news as $newsitem)
            <div class="card-news">

                @if ($newsitem->image)
                    <img src="{{ asset('storage/' . $newsitem->image) }}" alt="image" class="img-fluid">
                @else
                    <img src="https://source.unsplash.com/400x400?music" alt="image" class="img-fluid">
                @endif

                <h3><a href="/news/{{ $newsitem->slug }}" class="text-decoration-none">{{ $newsitem->title }}</a></h3>
                <p>
                    <small class="text-muted">
                        {{ $newsitem->created_at->diffForHumans() }}
                    </small>
                </p>

                {{ $newsitem->excerpt }}

                <a href="/news/{{ $newsitem->slug }}" class="text-decoration-none">Read More</a>
            </div>
        @endforeach

    </div>

    @if ($count < $totalNews)
        <button class="btn btn-home text-center" wire:click="loadMore">Load More</button>
    @endif

    <span class="loading" wire:loading>
        <div class="loading-spinner"></div>
    </span>
</div>
