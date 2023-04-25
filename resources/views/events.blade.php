@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($events as $eventitem)

        <div class="col-md-4">
            <div class="card mb-5">
                <div class="card-body">
                    <article class="pb-3">
                        <h3><a href="/events/{{ $eventitem->slug }}" class="text-decoration-none"> {{
                                $eventitem->eventname
                                }}</a></h3>
                        <p>{{ $eventitem->time }}</p>

                        <p>{{ $eventitem->formatted_date }}</p>

                    </article>
                </div>
            </div>
        </div>
        
        @endforeach
    </div>
</div>
@endsection