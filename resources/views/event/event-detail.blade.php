@extends('layouts.main')

@section('content-page')
<div class="detail-event" id="detailEvent">
    <div class="bg-left"></div>
    <div class="bg-right"></div>
    <div class="bg-opacity"></div>
    <div class="wrapper">
        <div class="content">
            <h1>{{ $event->eventname }}</h1>
            @if (!empty($event->image))
            <div class="box-image">
                <img id="eventImage" src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->slug }}">
            </div>
            <div id="imagePopup" class="image-popup">
                <span class="close-popup" id="closePopup"></span>
                <img id="popupImage" src="" alt="Popup Image">
            </div>
            @endif
            <div class="timer-container">
                @if ($event->date > now())
                <div class="timer-box">
                    <div class="timer-value" id="days"></div>
                    <div class="timer-label">days</div>
                </div>
                <div class="timer-box">
                    <div class="timer-value" id="hours"></div>
                    <div class="timer-label">hours</div>
                </div>
                <div class="timer-box">
                    <div class="timer-value" id="minutes"></div>
                    <div class="timer-label">minutes</div>
                </div>
                <div class="timer-box">
                    <div class="timer-value" id="seconds"></div>
                    <div class="timer-label">seconds</div>
                </div>
                @else
                <h3 class="pass-event">This event has ended {{ now()->diffInDays($event->date) }} days ago.
                </h3>
                @endif
            </div>

            <div class="detail-content">
                <div class="list-detail">
                    <img src="{{ url('/assets/img/icons/icon-calendar.png') }}" alt="">
                    <p>{{ date('F d, Y', strtotime($event->date)) }}</p>
                </div>
                <div class="list-detail">
                    <img src="{{ url('/assets/img/icons/icon-clock.png') }}" alt="">
                    <p>{{ date('g:i A', strtotime($event->time)) }}</p>
                </div>
                <div class="list-detail">
                    <img src="{{ url('/assets/img/icons/icon-location.png') }}" alt="">
                    @if ($event->maps)
                    <a href="{{ $event->maps }}" class="text-decoration-none" target="blank">{{ $event->location }}</a>
                    @else
                    <p>{{ $event->location }}</p>
                    @endif

                </div>
                {{-- <div class="list-detail">
                    <img src="{{ url('/assets/img/icons/icon-location-d.png') }}" alt="">
                    <p>{{ $event->location }}</p>
                </div> --}}
            </div>
            <div class="share">
                <p>Share this event</p>
                <div class="icons">

                    @foreach ($shareLinks as $platform => $link)
                    <a href="{{ $link }}" target="_blank" target="_blank"
                        onclick="openSmallWindow(event, '{{ $link }}')"><img
                            src="{{ url('./assets/img/icons/icon-' . $platform . '.png') }}" alt=""></a>
                    @endforeach


                </div>
            </div>
            @if ($event->more_information)
            <a href="{{ $event->more_information }}" class="btn btn-home mt-4 mb-1 mx-5">More Information</a>
            @endif
        </div>
    </div>
</div>
</div>
@endsection

<script>
    // Fungsi untuk menghitung waktu mundur
    function countdown() {
        var eventDate = new Date("{{ $event->date }}").getTime(); // Konversi tanggal menjadi waktu dalam milidetik
        var now = new Date().getTime(); // Waktu sekarang dalam milidetik
        var distance = eventDate - now; // Selisih waktu antara eventDate dan now

        // Hitung hari, jam, menit, dan detik dari selisih waktu
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Tampilkan waktu mundur dalam elemen dengan ID yang sesuai
        document.getElementById("days").innerHTML = days;
        document.getElementById("hours").innerHTML = hours;
        document.getElementById("minutes").innerHTML = minutes;
        document.getElementById("seconds").innerHTML = seconds;

        // Perbarui waktu mundur setiap 1 detik (1000 milidetik)
        setTimeout(countdown, 1000);
    }

    // Panggil fungsi countdown saat halaman selesai dimuat
    window.onload = countdown;


    document.addEventListener("DOMContentLoaded", function() {
        const eventImage = document.getElementById("eventImage");
        const popupImage = document.getElementById("popupImage");
        const imagePopup = document.getElementById("imagePopup");
        const closePopup = document.getElementById("closePopup");

        eventImage.addEventListener("click", function() {
            const imageUrl = this.getAttribute("src");
            popupImage.setAttribute("src", imageUrl);
            imagePopup.style.display = "block";
        });

        closePopup.addEventListener("click", function() {
            imagePopup.style.display = "none";
        });

        imagePopup.addEventListener("click", function(event) {
            if (event.target === imagePopup) {
                imagePopup.style.display = "none";
            }
        });
    });
</script>