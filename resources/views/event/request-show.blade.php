@extends('layouts.main')

@section('content-page')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container-fluid" id="requestShow">
        <form class="row g-3" action="{{ route('showRequests.store') }}" method="POST">
            @csrf
            <div class="col-md-6 col-12">
                <label for="company_name" class="form-label">Name/Company name*</label>
                <input type="text" name="company_name"
                    class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" id="company_name"
                    value="{{ old('company_name') }}" autofocus>

                @if ($errors->has('company_name'))
                    <span class="invalid-feedback">{{ $errors->first('company_name') }}</span>
                @endif
            </div>
            <div class="col-md-6 col-12">
                <label for="eventname" class="form-label">Event name*</label>
                <input type="text" name="eventname"
                    class="form-control {{ $errors->has('eventname') ? ' is-invalid' : '' }}" value="{{ old('eventname') }}"
                    id="eventname">
                @if ($errors->has('eventname'))
                    <span class="invalid-feedback">{{ $errors->first('eventname') }}</span>
                @endif
            </div>
            {{-- <div class="col-md-6">
                <label for="duration" class="form-label">Duration*</label>
                <input type="teks" name="duration"
                    class="form-control {{ $errors->has('duration') ? ' is-invalid' : '' }}" value="{{ old('duration') }}"
                    id="duration">
                @if ($errors->has('duration'))
                    <span class="invalid-feedback">{{ $errors->first('duration') }}</span>
                @endif
            </div> --}}
            <div class="col-12">
                <label for="date" class="form-label">Event date*</label>
                <input type="date" name="date" class="form-control {{ $errors->has('date') ? ' is-invalid' : '' }}"
                    value="{{ old('date') }}" id="date">
                @if ($errors->has('date'))
                    <span class="invalid-feedback">{{ $errors->first('date') }}</span>
                @endif
            </div>
            <div class="col-12">
                <label for="location" class="form-label">Event Location*</label>
                <input type="text" name="location"
                    class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}" value="{{ old('location') }}"
                    id="location">
                @if ($errors->has('location'))
                    <span class="invalid-feedback">{{ $errors->first('location') }}</span>
                @endif
            </div>
            <div class="col-12">
                <label for="whatsapp" class="form-label">Whatsapp*</label>
                <input type="text" name="whatsapp"
                    class="form-control {{ $errors->has('whatsapp') ? ' is-invalid' : '' }}" value="{{ old('whatsapp') }}"
                    id="whatsapp">
                @if ($errors->has('whatsapp'))
                    <span class="invalid-feedback">{{ $errors->first('whatsapp') }}</span>
                @endif
            </div>
            <div class="col-12">
                <label for="email" class="form-label">Email*</label>
                <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                    value="{{ old('email') }}" id="email">
                @if ($errors->has('email'))
                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="col-12 {{ $errors->has('g-recaptcha-response') ? ' is-invalid' : '' }}">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display(['data-theme' => 'light', 'data-size' => 'normal', 'data-use-default-style' => 'true']) !!}

                @if ($errors->has('g-recaptcha-response'))
                    <span class=" text-danger">
                        {{ $errors->first('g-recaptcha-response') }}
                    </span>
                @endif
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-home">Submit</button>
            </div>
        </form>
    </div>
@endsection
