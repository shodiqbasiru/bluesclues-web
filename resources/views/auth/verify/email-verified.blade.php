@extends('layouts.main')

@section('content-page')
    <div class="container" id="emailVerified">
        <div class="wrapper">
            <div class="card text-center">
                <div class="card-header">{{ __('Email Verified') }}</div>

                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        {{ __('Your email address has been successfully verified.') }}
                    </div>

                    <a href="{{ route('merchandise.home') }}" class="btn btn-primary">{{ __('Go to Merchandise') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
