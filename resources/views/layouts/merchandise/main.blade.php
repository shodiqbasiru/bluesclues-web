<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <x-head.tinymce-config />

    {{-- <link rel="shortcut icon" href="{{ url('/assets/img/logo-blues.png') }}"> --}}
    {{-- <link rel="icon" type="image/x-icon" href="{{ url('/assets/img/logo-blues.png') }}"> --}}

    <title>Merchandise | Blues Clues</title>
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    {{-- swiper.js --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    {{-- MyCss --}}
    <link rel="stylesheet" href="{{ url('/assets/css/style.css') }}">
    @livewireStyles
</head>
</head>

<body>
    {{-- @include('merchandise.layouts.navigation') --}}
    <livewire:layout.navbar />

    <main>
        @yield('content')
        @include('layouts.merchandise.footer')
    </main>


    @livewireScripts

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    {{-- jquery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    {{-- swiper.js --}}
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

    {{-- ion icons --}}
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    {{-- MyScript --}}
    <script src="{{ url('/assets/js/script.js') }}"></script>

</body>

</html>
