@extends('layouts.main')

@section('content')
<div class="card mx-auto mt-5 text-center" style="width: 20rem;">
    <div class="card-body">
        <h5 class="card-title mb-4">{{  $event->eventname }}</h5>
        <h6 class="card-subtitle mb-2 text-body-secondary">{{  $event->time }}</h6>
        <h6 class="card-subtitle mb-2 text-body-secondary">{{  $event->formatted_date }}</h6>
        <p class="card-text">{{  $event->location }}</p>
        
    </div>
</div>
<div class="text-center">
    <p><a href="/events" class="text-decoration-none">Kembali ke Events</a></p>
</div>
@endsection