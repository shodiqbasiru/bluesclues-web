@extends('layouts.main')

@section('content')
<div class="container page-event">
    <div class="row">
        <div class="col-md-12">
            <div class="event-filter text-center" id="eventFilter">
                <a class="filter-btn{{ $filter === 'all' ? ' active' : '' }}"
                    href="{{ route('events', ['filter' => 'all']) }}" data-filter="all">All</a>
                <a class="filter-btn{{ $filter === 'currently' ? ' active' : '' }}"
                    href="{{ route('events', ['filter' => 'currently']) }}" data-filter="currently">Currently</a>
                <a class="filter-btn{{ $filter === 'past' ? ' active' : '' }}"
                    href="{{ route('events', ['filter' => 'past']) }}" data-filter="past">Past</a>
            </div>



            <div class="card mb-5">
                @foreach ($events->groupBy(function ($eventItem) {
                return \Carbon\Carbon::parse($eventItem->formatted_date)->format('F Y');
                }) as $month => $eventsByMonth)
                <div class="card-header">
                    <h2 class="text-center">{{ $month }}</h2>
                </div>
                @foreach ($eventsByMonth as $eventItem)
                <div class="card-body event-item"
                    data-date="{{ \Carbon\Carbon::parse($eventItem->formatted_date)->toDateString() }}"
                    data-filter="all currently">
                    <p class="date">
                        {{ \Carbon\Carbon::parse($eventItem->formatted_date)->format('d') }} <br>
                        {{ \Carbon\Carbon::parse($eventItem->formatted_date)->format('M') }}
                    </p>
                    <p class="title">
                        {{ $eventItem->eventname }} <br>
                        <span>{{ $eventItem->location }}</span>
                    </p>
                    <div class="card-logo">
                        <p>Share :</p>
                        <a href="#"><img src="{{ url('./assets/img/icons/facebook-b.svg') }}" alt=""></a>
                        <a href="#"><img src="{{ url('./assets/img/icons/instagram-b.svg') }}" alt=""></a>
                        <a href="#"><img src="{{ url('./assets/img/icons/youtube-b.svg') }}" alt=""></a>
                        <a href="#"><img src="{{ url('./assets/img/icons/Spotify-b.svg') }}" alt=""></a>
                        <a href="#"><img src="{{ url('./assets/img/icons/apple-b.svg') }}" alt=""></a>
                    </div>
                </div>
                @endforeach
                @endforeach
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <form action="{{ route('showRequests.store') }}" method="post">
            @csrf

            <div class="form-group my-3">
                <label for="company_name">Name / Company Name:</label>
                <input type="text"
                    class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('company_name') }}" id="company_name" name="company_name"
                    placeholder="Enter name or company name">
                @if ($errors->has('company_name'))
                <span class="invalid-feedback">{{ $errors->first('company_name') }}</span>
                @endif
            </div>

            <div class="form-group my-3">
                <label for="email">Email:</label>
                <input type="email" name="email"
                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                    value="{{ old('email') }}" id="email" placeholder="name@example.com" autofocus
                    required>
                @if ($errors->has('email'))
                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="date">Date of Show:</label>
                <input type="date"
                    class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('date') }}" id="date" name="date" placeholder="Enter date">
                @if ($errors->has('date'))
                <span class="invalid-feedback">{{ $errors->first('date') }}</span>
                @endif
            </div>


            <div class="form-group my-3">
                <label for="whatsapp">Whatsapp:</label>
                <input type="text"
                    class="form-control{{ $errors->has('whatsapp') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('whatsapp') }}" id="whatsapp" name="whatsapp"
                    placeholder="Enter whatsapp number">
                @if ($errors->has('whatsapp'))
                <span class="invalid-feedback">{{ $errors->first('whatsapp') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="eventname">Event Name:</label>
                <input type="text"
                    class="form-control{{ $errors->has('eventname') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('eventname') }}" id="eventname" name="eventname"
                    placeholder="Enter event name">
                @if ($errors->has('eventname'))
                <span class="invalid-feedback">{{ $errors->first('eventname') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="location">Location:</label>
                <input type="text"
                    class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('location') }}" id="location" name="location"
                    placeholder="Enter event location">
                @if ($errors->has('location'))
                <span class="invalid-feedback">{{ $errors->first('location') }}</span>
                @endif
            </div>

            <div class="d-flex justify-content-center">

                <div class="form-floating{{ $errors->has('g-recaptcha-response') ? ' is-invalid' : '' }}"">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display(['data-theme' => 'light', 'data-size' => 'normal', 'data-use-default-style' => 'true']) !!}


                @if ($errors->has('g-recaptcha-response'))
                <span class=" text-danger">
                    {{ $errors->first('g-recaptcha-response') }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button class="btn btn-lg btn-primary mt-3" type="submit">Submit</button>
            </div>
        </form>
        
    </div>
</div>
@endsection