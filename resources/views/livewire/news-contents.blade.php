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
                <div class="d-flex justify-content-between">
                    <p>
                        <small class="text-muted">
                            {{ $newsitem->created_at->diffForHumans() }}
                        </small>
                    </p>

                    <p>
                        <small class="text-muted">
                            @if (!empty($newsitem->viewers))
                                {{ $newsitem->viewers }} <i class="fas fa-eye ms-1"></i>
                            @else
                                0 <i class="fas fa-eye ms-1"></i>
                            @endif
                        </small>
                    </p>

                </div>

                {{ $newsitem->excerpt }}

                <a href="/news/{{ $newsitem->slug }}" class="text-decoration-none">Read More</a>
            </div>
        @endforeach

    </div>

    @if ($count < $totalNews)
        <div wire:loading.remove class="text-center">
            <button class="btn btn-home" wire:click="loadMore">Load More</button>
        </div>
    @endif

    <div class="loading " wire:loading>
        <div class="loading-spinner"></div>
    </div>

</div>
