@extends('layouts.main')

@section('content-page')
    <div class="detail-event" id="detailEvent">
        <div class="wrapper">
            <div class="content">
                <h1>{{ $event->eventname }}</h1>
                <p>{{ $event->location }}</p>
                <p>{{ date('d F Y', strtotime($event->date)) }}</p>
                <div class="timer-container">
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
</script>
