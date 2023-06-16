@extends('layouts.main')

@section('content-page')
<div class="container-fluid page-news">
    <h2>News</h2>
    <div class="news" id="news">
        @foreach ($news as $newsitem)
        <div class="card-news">

            @if ($newsitem->image)
            <img src="{{ asset('storage/' . $newsitem->image) }}" alt="image" class="img-fluid">
            @else
            <img src="https://source.unsplash.com/400x400?music " alt="image" class="img-fluid">

            @endif

            <h3><a href="/news/{{ $newsitem->slug }}" class="text-decoration-none"> {{ $newsitem->title
                    }}</a></h3>
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
</div>


@endsection

{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        var loadMoreBtn = document.querySelector('.load-more');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener("click", function() {
                var skip = loadMoreBtn.getAttribute('data-skip');
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "{{ route('news') }}?skip=" + skip);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        var dataWrapper = document.querySelector('.data-wrapper');
                        dataWrapper.insertAdjacentHTML('beforeend', response.html);
                        if (response.data.length == 0) {
                            loadMoreBtn.style.display = "none";
                        } else {
                            loadMoreBtn.setAttribute('data-skip', parseInt(skip) + response.data.length);
                        }
                    }
                };
                xhr.send();
            });
        }
    });
    </script> --}}
    