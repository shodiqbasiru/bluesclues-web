@extends('merchandise.layouts.main')

@section('content')
    <div class="auth" id="user">
        @if (session('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('loginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1>Create Account</h1>

        <form action="{{ route('admin.authenticate') }}" method="post">
            @csrf
            <div class="form-group">
                <input type="email" name="email" class="myinput {{ $errors->has('email') ? ' is-invalid' : '' }}"
                    value="{{ old('email') }}" id="email" required>
                <label for="email" class="mylabel">Email</label>
                @if ($errors->has('email'))
                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="username" name="username" class="myinput {{ $errors->has('username') ? ' is-invalid' : '' }}"
                    value="{{ old('username') }}" id="username" required>
                <label for="username" class="mylabel">Username</label>
                @if ($errors->has('username'))
                    <span class="invalid-feedback">{{ $errors->first('username') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" name="password"
                    class="myinput pass {{ $errors->has('password') ? ' is-invalid' : '' }}" id="pasword" required>
                <label for="password" class="mylabel">Password</label>
                @if ($errors->has('password'))
                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" name=""
                    class="myinput {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" id="pasword"
                    required>
                <label for="password_confirmation" class="mylabel">Confirm Password</label>
            </div>
            <button type="submit" class="btn">Daftar</button>
            <a href="#" class="forgetpass">Already have an account?</a>
        </form>
    </div>
@endsection

</html>