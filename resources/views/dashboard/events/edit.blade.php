@extends('dashboard.layouts.main')

@section('content')


<div class="container my-5">
    <a href="/admin/dashboard/events" class="btn btn-transparent me-2">
        <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left" class="me-1"></span> Back to Events</div>
    </a>
    <h1>Edit event</h1>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('events.update', $event->slug) }}">
        @method('put')
        @csrf
        <div class="form-group my-3">
            <label for="eventname">Event Name:</label>
            <input type="text" class="form-control{{ $errors->has('eventname') ? ' is-invalid' : '' }} mt-2"
                value="{{ old('eventname', $event->eventname) }}" id="eventname" name="eventname" placeholder="Enter event name">
            @if ($errors->has('eventname'))
            <span class="invalid-feedback">{{ $errors->first('eventname') }}</span>
            @endif
        </div>
        <div class="form-group my-3">
            <label for="location">Location:</label>
            <input type="text" class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }} mt-2"
                value="{{ old('location', $event->location) }}" id="location" name="location" placeholder="Enter location">
            @if ($errors->has('location'))
            <span class="invalid-feedback">{{ $errors->first('location') }}</span>
            @endif
        </div>
        <div class="form-group my-3">
            <label for="time">Time:</label>
            <input type="time" class="form-control" id="time" name="time" min="00:00" max="23:59" value="{{ old('time', $event->time) }}"
                required>
            @if ($errors->has('time'))
            <span class="invalid-feedback">{{ $errors->first('time') }}</span>
            @endif
        </div>
        <div class="form-group my-3">
            <label for="date">Date:</label>
            <input type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }} mt-2"
                value="{{ old('date', $formattedDate) }}" id="date" name="date" placeholder="Enter date">
            @if ($errors->has('date'))
            <span class="invalid-feedback">{{ $errors->first('date') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-outline-light mt-4">Save</button>
    </form>
</div>
@endsection