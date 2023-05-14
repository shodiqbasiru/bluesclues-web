@extends('layouts.main')

@section('content-page')
<div class="page-video">

  <div id="video-header">
    <div class="header-img">
      <img src="{{ $videos[0]['thumbnail'] }}" alt="{{ $videos[0]['title'] }}" class="video-thumbnail"data-video-id="{{ $videos[0]['id'] }}" id="thumbnail_{{ $videos[0]['id'] }}">
      <img src="{{ url('./assets/img/icons/s-play.png') }}" alt="icon-play" class="btn-play">
    </div>

    <div class="title">
      <h2>{{ $videos[0]['title'] }}</h2>
      <div class="icons">
        <p>Share</p>
         <img src="{{ url('./assets/img/icons/circle_fb.svg') }}" alt="">
         <img src="{{ url('./assets/img/icons/circle_twit.svg') }}" alt="">
         <img src="{{ url('./assets/img/icons/circle_google.svg') }}" alt="">
         <img src="{{ url('./assets/img/icons/circle_t.svg') }}" alt="">
         <img src="{{ url('./assets/img/icons/circle_insta.svg') }}" alt="">
      </div>
    </div>

  </div>
  
  <div class="body">
    @foreach($videos as $key => $video)
      @if($key === 0)
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
  
  <a href="#" class="btn btn-home text-center">Load More</a>

  <div id="video-container" style="display:none">
      <iframe id="video-player" width="560" height="315" src="" frameborder="0" allowfullscreen></iframe>
  </div>
</div>


<script>
// videos page
var videoContainer = document.getElementById("video-container");
var videoPlayer = document.getElementById("video-player");

// Add click event listener to each video thumbnail
var thumbnails = document.querySelectorAll(".video-thumbnail, .overlay");
thumbnails.forEach(function (thumbnail) {
    thumbnail.addEventListener("click", function () {
        // Get the video ID from the data-video-id attribute
        var videoId = this.getAttribute("data-video-id");

        // Set the src attribute of the video player with the video ID
        videoPlayer.setAttribute(
            "src",
            "https://www.youtube.com/embed/" + videoId
        );

        // Show the video player container
        videoContainer.style.display = "block";
    });
});

// Add click event listener to the video player container to hide it when clicked
videoContainer.addEventListener("click", function () {
    videoPlayer.setAttribute("src", "");
    videoContainer.style.display = "none";
});

</script>

@endsection