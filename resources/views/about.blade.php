@extends('layouts.main')

@section('content-page')
    <div class="page-about" id="p-about">
        <div class="hero">
            <img src="{{ url('/assets/img/about/hero_about.png') }}" alt="">
        </div>
        <div class="container-lg content text-center">
            <img class="blues-logo" src="{{ url('/assets/img/icons/logo_2.png') }}" alt="">
            <p><span>Blues Clues terbentuk di tahun 2020</span>, saat pandemic tengah melanda dunia. Berawal dari obrolan
                warung kopi atas situasi yang cukup pelik saat itu, terbesitlah ide untuk mencoba bereksplorasi dalam ranah
                musik dan lirik. Adalah, <span>Sultan dan Hamid</span> yang menjadi biang kerok eksperimen lagu-lagu blues.
                Dua orang inilah yang ingin agar sebuah band melahirkan karya-karya lagu <span>blues original</span> yang
                penuh dengan eksplorasi pada bidang seni yang lain.</p>
            <p>Bermula dengan menjadikan <span>puisi sebagai paduan lirik dalam berblues ria</span>, eksplorasi pun meluas
                pada genre-genre music yang ada khususnya memadukan music <span>tradisional dengan blues</span>. Pada
                akhirnya Blues Clues terus bertransformasi menjadi sebuah grup music yang berhasil melahirkan karya-karya
                dalam waktu yang relative singkat.</p>
            <p>Terhitung sejak tahun 2022 Blues Clues berhasil menelurkan <span>mini album</span> yang berkolabroasi dengan
                seorang penulis puisi <span>Untung Wardojo</span>, dan di awal tahun 2023 Blues Clues menelurkan 2 single
                yang memiliki nuansa tradisi sunda yang kental.</p>

            <div class="content-song">
                <h4>Album</h4>
                <div class="album">
                    <img src="{{ url('./assets/img/about/album-1.png') }}" alt="">
                </div>
                <h4>Single</h4>
                <div class="single">
                    <img src="{{ url('./assets/img/about/single-1.png') }}" alt="">
                    <img src="{{ url('./assets/img/about/single-2.png') }}" alt="">
                    <img src="{{ url('./assets/img/about/single-3.png') }}" alt="">
                </div>
            </div>
        </div>

    </div>
@endsection
