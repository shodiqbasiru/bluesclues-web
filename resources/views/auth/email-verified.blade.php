

@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-header">{{ __('Email Verified') }}</div>

                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            {{ __('Your email address has been successfully verified.') }}
                        </div>
                        
                        <a href="/" class="btn btn-primary">{{ __('Go to Home Page') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
