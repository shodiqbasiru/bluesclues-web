@extends('layouts.main')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <form action="{{ route('message.store') }}" method="post">
            @csrf

            <div class="form-group my-3">
                <label for="name">Name:</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('name') }}" id="name" name="name" placeholder="Enter name">
                @if ($errors->has('name'))
                <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group my-3">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                    value="{{ old('email') }}" id="email" placeholder="name@example.com" autofocus required>
                @if ($errors->has('email'))
                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="subject">Subject:</label>
                <input type="text" class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('subject') }}" id="subject" name="subject" placeholder="Enter subject of the message">
                @if ($errors->has('subject'))
                <span class="invalid-feedback">{{ $errors->first('subject') }}</span>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="whatsapp">Whatsapp:</label>
                <input type="text" class="form-control{{ $errors->has('whatsapp') ? ' is-invalid' : '' }} mt-2"
                    value="{{ old('whatsapp') }}" id="whatsapp" name="whatsapp" placeholder="Enter whatsapp number">
                @if ($errors->has('whatsapp'))
                <span class="invalid-feedback">{{ $errors->first('whatsapp') }}</span>
                @endif
            </div>

            <div class="form-group my-3">
                <label for="message_content">Message:</label>
                <textarea placeholder="Your message"
                    class="form-control{{ $errors->has('message_content') ? ' is-invalid' : '' }} mt-2"
                    id="message_content" name="message_content" rows="6" cols="40" style="resize: none;">{{ old('message_content') }}</textarea>
                @if ($errors->has('message_content'))
                <span class="invalid-feedback">{{ $errors->first('message_content') }}</span>
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