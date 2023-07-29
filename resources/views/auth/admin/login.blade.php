@extends('auth.main')

@section('content')
    <div class="auth" id="admin">
        @if (session('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('loginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1>{{ $title }}</h1>

        <form action="{{ route('admin.authenticate') }}" method="post">
            @csrf
            <div class="form-group">
                <input type="email" name="email"
                    class="myinput {{ $errors->has('email') ? ' is-invalid errorForm ' : '' }}" value="{{ old('email') }}"
                    id="email">
                <label for="email" class="mylabel">Email</label>
                @if ($errors->has('email'))
                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" name="password"
                    class="myinput {{ $errors->has('password') ? ' is-invalid errorForm ' : '' }}" id="pasword">
                <label for="password" class="mylabel">Password</label>
                @if ($errors->has('password'))
                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <button type="submit" class="btn">Sign In</button>
        </form>
    </div>
@endsection

</html>
