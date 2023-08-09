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
    <div class="card mx-auto mt-3 text-center" style="width: 20rem;">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $event->eventname }}</h5>
            <h6 class="card-subtitle mb-2 text-body-secondary">{{ $event->time }}</h6>
            <h6 class="card-subtitle mb-2 text-body-secondary">{{ $event->formatted_date }}</h6>
            <p class="card-text">{{ $event->location }}</p>

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
