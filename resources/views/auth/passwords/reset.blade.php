@extends('layouts.blog')

@section('doc_title', 'Reset Password - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4 overflow-auto">
        <h2>Reset Password</h2>
    </div>

    <div class="d-flex justify-content-center">
        <form method="POST" action="{{ route('password.update') }}" class="col-md-10 p-5 border rounded">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <h5 class="form-label-group text-center">Reset Your Password.</h5>

            <div class="form-label-group">
                <input class="form-control @error('email') is-invalid @enderror"
                       id="email" type="email" name="email" value="{{ $email ?? old('email') }}" autocomplete="email"
                       placeholder="Email Address"/>
                <label for="email">Email address</label>
                @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-label-group">
                <input class="form-control @error('password') is-invalid @enderror"
                       id="password" type="password" name="password" autocomplete="new-password"
                       placeholder="Password"/>
                <label for="password">Password</label>
                @error('password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-label-group">
                <input class="form-control" id="password-confirm" type="password"
                       name="password_confirmation" placeholder="Confirm Password"/>
                <label for="password-confirm">Confirm Password</label>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>

        </form>
    </div>
@endsection
