@extends('dashboard.layouts.main')

@section('content')


<div class="container my-5">
    <a href="{{ route('admin.index') }}" class="btn btn-transparent me-2">
        <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left"
                class="me-1"></span> Back to Admins</div>
    </a>
    <h1>Add admin account</h1>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->has('error'))
    <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
        {{ $errors->first('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <form method="POST" action="{{ route('admin.store') }}">
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
            <label for="email">email:</label>
            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} mt-2"
                value="{{ old('email') }}" id="email" name="email" placeholder="Enter email">
            @if ($errors->has('email'))
            <span class="invalid-feedback">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="form-group my-3">
            <label for="password" class="mylabel">Password</label>
            <input type="password" name="password"
                class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} mt-2" id="pasword">
            @if ($errors->has('password'))
            <span class="invalid-feedback">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <div class="form-group my-3">
            <label for="password_confirmation" class="mylabel">Confirm Password</label>
            <input type="password" name="password_confirmation"
                class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }} mt-2" id="pasword">
        </div>
        <button type="submit" class="btn btn-outline-light mt-4">Add account</button>
    </form>
</div>
@endsection