@extends('layouts.main')

@section('news')
<div class="container-fluid page-about p-5" id="p-about">
    <div class="container-lg hero">
        <img src="{{ url('/assets/img/hero_about_1.png') }}" alt="">
        <img src="{{ url('/assets/img/hero_about_2.png') }}" class="position" alt="">
        <img src="{{ url('/assets/img/hero_about_3.png') }}" alt="">
        <img src="{{ url('/assets/img/hero_about_4.png') }}" class="position" alt="">
    </div>
    <div class="container-lg content text-center">
        <img src="{{ url('/assets/img/logo_2.png') }}" alt="">
        <table>
            <tr>
              <td class="roles">vocal </td>
              <td>:</td>
              <td class="name"> Sultan</td>
            </tr>
            <tr>
              <td class="roles">Guitar </td>
              <td>:</td>
              <td class="name"> fulan</td>
            </tr>
            <tr>
              <td class="roles">Bass </td>
              <td>:</td>
              <td class="name"> fulan</td>
            </tr>
            <tr>
              <td class="roles">Drums </td>
              <td>:</td>
              <td class="name"> fulan</td>
            </tr>
        </table>
        <p><span>Blues Clues terbentuk di tahun 2020</span>, saat pandemic tengah melanda dunia. Berawal dari obrolan warung kopi atas situasi yang cukup pelik saat itu, terbesitlah ide untuk mencoba bereksplorasi dalam ranah musik dan lirik. Adalah, <span>Sultan dan Hamid</span> yang menjadi biang kerok eksperimen lagu-lagu blues. Dua orang inilah yang ingin agar sebuah band melahirkan karya-karya lagu <span>blues original</span> yang penuh dengan eksplorasi pada bidang seni yang lain.</p>
        <p>Bermula dengan menjadikan <span>puisi sebagai paduan lirik dalam berblues ria</span>, eksplorasi pun meluas pada genre-genre music yang ada khususnya memadukan music <span>tradisional dengan blues</span>. Pada akhirnya Blues Clues terus bertransformasi menjadi sebuah grup music yang berhasil melahirkan karya-karya dalam waktu yang relative singkat.</p>
        <p>Terhitung sejak tahun 2022 Blues Clues berhasil menelurkan <span>mini album</span> yang berkolabroasi dengan seorang penulis puisi <span>Untung Wardojo</span>, dan di awal tahun 2023 Blues Clues menelurkan 2 single yang memiliki nuansa tradisi sunda yang kental.</p>
    </div>
    
</div>
    
@endsection