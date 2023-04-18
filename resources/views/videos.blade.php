@extends('layouts.main')

@section('content')
<style>
    #video-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.8);
        display: none;
        z-index: 9999;
    }

    #video-container iframe {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        height: 80%;
    }
</style>

<div class="row mt-5">
    @foreach($videos as $video)
    <div class="col-md-4 mb-5">
        <div class="video text-center">
            <img src="{{ $video['thumbnail'] }}" alt="{{ $video['title'] }}" class="video-thumbnail"
                data-video-id="{{ $video['id'] }}" id="thumbnail_{{ $video['id'] }}">
            <h5>{{ $video['title'] }}</h5>

        </div>
    </div>
    
    @endforeach
</div>

<div id="video-container" style="display:none">
    <iframe id="video-player" width="560" height="315" src="" frameborder="0" allowfullscreen></iframe>
</div>


<script>
    var videoContainer = document.getElementById('video-container');
    var videoPlayer = document.getElementById('video-player');
  
    // Add click event listener to each video thumbnail
    var thumbnails = document.querySelectorAll('.video-thumbnail ');
    thumbnails.forEach(function(thumbnail) {
      thumbnail.addEventListener('click', function() {
        // Get the video ID from the data-video-id attribute
        var videoId = this.getAttribute('data-video-id');
  
        // Set the src attribute of the video player with the video ID
        videoPlayer.setAttribute('src', 'https://www.youtube.com/embed/' + videoId);
  
        // Show the video player container
        videoContainer.style.display = 'block';
      });
    });
  
    // Add click event listener to the video player container to hide it when clicked
    videoContainer.addEventListener('click', function() {
      videoPlayer.setAttribute('src', '');
      videoContainer.style.display = 'none';
    });
</script>

@endsection