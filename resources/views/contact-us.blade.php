@extends('layouts.main')

@section('content-page')
    <div class="page-contact" id="contact">
        <div class="hero">
            <img src="{{ url('/assets/img/bg-contact.jpg') }}" alt="">
        </div>
        <div class="content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="contact-information">
                <h4>Contact Information</h4>
                <p><span>Email :</span> bluesclues@gmail.com</p>
                <p><span>Phone :</span> +6281122456908</p>
            </div>
            <div class="form">
                <h4>Get in touch</h4>
                <form action="{{ route('message.store') }}" class="row g-3" method="POST">
                    @csrf
                    <div class="col-12">
                        <label for="name" class="form-label">Name*</label>
                        <input type="text" name="name"
                            class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"
                            value="{{ old('name') }}" placeholder="Please enter your name" required>
                        @if ($errors->has('name'))
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="col-lg-6 col-12">
                        <label for="email" class="form-label">Your E-mail*</label>
                        <input type="email" name="email"
                            class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email"
                            value="{{ old('email') }}" placeholder="Please enter your E-mail" required>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="col-lg-6 col-12">
                        <label for="whatsapp" class="form-label">Whatsapp*</label>
                        <input type="text" name="whatsapp"
                            class="form-control {{ $errors->has('whatsapp') ? ' is-invalid' : '' }}" id="whatsapp"
                            value="{{ old('whatsapp') }}" placeholder="Please enter your whatsapp number" required>
                        @if ($errors->has('whatsapp'))
                            <span class="invalid-feedback">{{ $errors->first('whatsapp') }}</span>
                        @endif
                    </div>
                    <div class="col-12">
                        <label for="subject" class="form-label">Subject*</label>
                        <input type="text" name="subject"
                            class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}" id="subject"
                            value="{{ old('subject') }}" placeholder="Please enter the subject of the message" required>
                        @if ($errors->has('subject'))
                            <span class="invalid-feedback">{{ $errors->first('subject') }}</span>
                        @endif
                    </div>
                    <div class="col-12">
                        <label for="message_content" class="form-label">Message*</label>
                        <textarea name="message_content" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}"
                            id="message_content" placeholder="Please enter your message" rows="3" required>{{ old('message_content') }}</textarea>
                    </div>
                    <div class="col-12 text-center {{ $errors->has('g-recaptcha-response') ? ' is-invalid' : '' }}">
                        {!! NoCaptcha::renderJs() !!}
                        {!! NoCaptcha::display(['data-theme' => 'light', 'data-size' => 'normal', 'data-use-default-style' => 'true']) !!}

                        @if ($errors->has('g-recaptcha-response'))
                            <span class=" text-danger">
                                {{ $errors->first('g-recaptcha-response') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-home">Sumbit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection