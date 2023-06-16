@extends('layouts.main')

@section('content-page')
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
                                    <a href="#"><img src="{{ url('./assets/img/icons/facebook-b.svg') }}"
                                            alt=""></a>
                                    <a href="#"><img src="{{ url('./assets/img/icons/instagram-b.svg') }}"
                                            alt=""></a>
                                    <a href="#"><img src="{{ url('./assets/img/icons/youtube-b.svg') }}"
                                            alt=""></a>
                                    <a href="#"><img src="{{ url('./assets/img/icons/Spotify-b.svg') }}"
                                            alt=""></a>
                                    <a href="#"><img src="{{ url('./assets/img/icons/apple-b.svg') }}"
                                            alt=""></a>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <button class="btn btn-event" data-bs-toggle="modal" data-bs-target="#exampleModal">Request a Show</button>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Request Show</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name/Company name</label>
                                    <input type="text" name="name" class="form-control" id="name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date Of Show</label>
                                    <input type="date" class="form-control" id="date" name="date">
                                </div>
                                <div class="mb-3">
                                    <label for="whatsapp" class="form-label">Whatsapp</label>
                                    <input type="text" class="form-control" id="date" name="whatsapp">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
