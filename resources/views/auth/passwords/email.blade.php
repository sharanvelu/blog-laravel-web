@extends('layouts.blog')

@section('doc_title', 'Reset Password - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4 overflow-auto">
        <h2>Reset Password</h2>
    </div>

    <div class="d-flex justify-content-center">
        <form method="POST" action="{{ route('password.email') }}" class="col-md-10 p-5 border rounded">
            @csrf

            <h5 class="form-label-group text-center">Enter your email to get your password reset link.</h5>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="form-label-group">
                <input class="form-control @error('email') is-invalid @enderror"
                       id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                       placeholder="Email Address" required autofocus />
                <label for="email">Email address</label>
                @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Send Password Reset Link</button>

            <div class="text-center mt-5">
                Not a member? <a href="{{ route('register') }}" class="text-decoration-none">Sign up Now</a>
            </div>
        </form>
    </div>
@endsection
