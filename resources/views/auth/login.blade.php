@extends('layouts.blog')

@section('doc_title', 'Login - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4 overflow-auto">
        <h2>Login</h2>
    </div>

    <div class="d-flex justify-content-center">
        <form method="POST" action="{{ route('login') }}" class="col-md-10 p-5 border rounded">
            @csrf
            <h5 class="form-label-group text-center">Provide Your credentials to get Logged-in.</h5>

            <div class="form-label-group">
                <input class="form-control @error('email') is-invalid @enderror"
                       id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                       placeholder="Email Address" required autofocus/>
                <label for="email">Email address</label>
                @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-label-group">
                <input class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                       id="password" type="password" name="password" required
                       autocomplete="current-password"/>
                <label for="password">Password</label>
                @error('password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="row m-0">
                <div class="col-12 col-sm-5 checkbox p-1">
                    <label><input type="checkbox" name="remember" id="remember" class="mr-2"
                            {{ old('remember') ? 'checked' : '' }}>Remember me</label>
                </div>
                <div class="col-12 col-sm-7 text-left text-sm-right p-1">
                    @if (Route::has('password.request'))
                        <a class="text-decoration-none" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>

            <button class="mx-auto mt-3 col-6 btn btn-lg btn-outline-primary btn-block rounded-pill" type="submit">Login</button>

            <div class="text-center mt-5">
                Not a member? <a href="{{ route('register') }}" class="text-decoration-none">Sign up Now</a>
            </div>
        </form>
    </div>
@endsection
