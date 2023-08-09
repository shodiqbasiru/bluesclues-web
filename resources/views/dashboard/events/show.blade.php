@extends('dashboard.layouts.main')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <a href="{{ url()->previous() }}" class="btn btn-transparent me-2 mb-2">
        <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left"
                class="me-1"></span> Back to Events</div>
    </a>
</div>
<div class="d-flex justify-content-center">

    <a href="/admin/dashboard/events/{{ $event->slug }}/edit" class="btn btn-outline-light me-2">
        <div class="d-flex justify-content-center align-items-center"><span data-feather="edit" class="me-1"></span>
            Edit</div>
    </a>
    <form action="/admin/dashboard/events/{{ $event->slug }}" method="post" class="d-inline">
        @method('delete')
        @csrf
        <button type="submit" class="btn btn-outline-light me-2">
            <div class="d-flex justify-content-center align-items-center"
                onclick="return confirm ('Are you sure to delete this entry?')"><span data-feather="trash"
                    class="me-1"></span>
                Delete</div>
        </button>
    </form>
</div>
<div class="card mx-auto my-5 text-center" style="width: 20rem;">
    <div class="card-body">
        <h5 class="card-title mb-4">{{ $event->eventname }}</h5>
        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $event->time }}</h6>
        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $event->formatted_date }}</h6>
        <h6 class="card-subtitle mb-2 text-body-secondary">
            @if ($event->is_free == '1')
            Free Event
            @else
            Paid Event
            @endif
        </h6>
        <p class="card-text">{{ $event->location }}</p>
        @if ($event->maps)
        <a href="{{ $event->maps }}" target="_blank" class="btn btn-sm btn-danger mb-5"><i
                class="fas fa-location-dot mx-3" style="color: white;"></i></a>
        @endif
        @if ($event->image)
        <img src="{{ asset('storage/' . $event->image) }}" alt="image" class="img-fluid">
        @endif

        @if ($event->more_information)
        <h6 class="mt-3"> More Information Link:
            <a href="{{ $event->more_information }}" target="_blank">
                {{ $event->more_information }}
            </a>
        </h6>
        @endif

    </div>
</div>

{{-- @foreach ($event as $item)
<div class="card mx-auto mt-3 text-center" style="width: 20rem;">
    <div class="card-body">
        <h5 class="card-title mb-4">{{ $item->eventname }}</h5>
        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $item->time }}</h6>
        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $item->formatted_date }}</h6>
        <p class="card-text">{{ $item->location }}</p>

    </div>
</div>
@endforeach --}}
@endsection