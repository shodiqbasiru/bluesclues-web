@extends('dashboard.layouts.main')

@section('content')


<div class="container my-5">
    <a href="/admin/dashboard/admins" class="btn btn-transparent me-2">
        <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left" class="me-1"></span> Back to Admins</div>
    </a>
    <h1>Change Password</h1>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.update') }}">
        @csrf

        <div class="form-group my-3">
            <label for="name">Name:</label>
            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} mt-2"
                value="{{ old('name', $admin->name) }}" id="name" name="name" placeholder="Enter name" readonly>
            @if ($errors->has('name'))
            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="form-group my-3">
            <label for="email">email:</label>
            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} mt-2"
                value="{{ old('name', $admin->email) }}" id="email" name="email" placeholder="Enter email" readonly>
            @if ($errors->has('email'))
            <span class="invalid-feedback">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="form-group my-3">
            <label for="current_password" class="mylabel">Current Password</label>
            <input type="password" name="current_password"
                class="form-control {{ $errors->has('current_password') ? ' is-invalid' : '' }} mt-2" id="pasword">
                @if ($errors->has('current_password'))
                <span class="invalid-feedback">{{ $errors->first('current_password') }}</span>
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
       <button type="submit" class="btn btn-outline-light mt-4">Save</button>
    </form>
</div>
@endsection