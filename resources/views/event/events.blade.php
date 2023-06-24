@extends('layouts.main')

@section('content-page')
    <div class="container page-event">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row justify-content-center">
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
                            <h2 class="text-center m-0">{{ $month }}</h2>
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
                                    <a href="#"><img src="{{ url('./assets/img/icons/icon-facebook.png') }}"
                                            alt=""></a>
                                    <a href="#"><img src="{{ url('./assets/img/icons/icon-instagram.png') }}"
                                            alt=""></a>
                                    <a href="#"><img src="{{ url('./assets/img/icons/icon-twitter.png') }}"
                                            alt=""></a>
                                    <a href="#"><img src="{{ url('./assets/img/icons/icon-whatsapp.png') }}"
                                            alt=""></a>

                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            <div class="col-md-8">

                <a href="/events/request-show" class="btn btn-event">Request a Show</a>
            </div>
        </div>
    </div>
@endsection
