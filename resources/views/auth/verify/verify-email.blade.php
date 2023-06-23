{{-- resources/views/auth/verify-email.blade.php --}}

@extends('layouts.main')

@section('content-page')


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('message'))
            <div class="alert alert-success text-center">{{ session('message') }}</div>
            @else
            <div class="card text-center">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request
                            another') }}</button>.
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection