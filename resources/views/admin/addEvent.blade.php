@extends('layouts.main')

@section('content')

<div class="container">
    <h1>Tambah Event</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('events.store') }}">
        @csrf
        <div class="form-group">
            <label for="eventname">Event Name:</label>
            <input type="text" class="form-control{{ $errors->has('eventname') ? ' is-invalid' : '' }}" value="{{ old('eventname') }}" id="eventname" name="eventname" placeholder="Enter event name" >
            @if ($errors->has('eventname'))
            <span class="invalid-feedback">{{ $errors->first('eventname') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" value="{{ old('location') }}" id="location" name="location" placeholder="Enter location" >
            @if ($errors->has('location'))
            <span class="invalid-feedback">{{ $errors->first('location') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="time">Time:</label>
            <input type="text" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" value="{{ old('time') }}" id="time" name="time" placeholder="Enter time" >
            @if ($errors->has('time'))
            <span class="invalid-feedback">{{ $errors->first('time') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" value="{{ old('date') }}" id="date" name="date" placeholder="Enter date" >
            @if ($errors->has('date'))
            <span class="invalid-feedback">{{ $errors->first('date') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>          
@endsection



