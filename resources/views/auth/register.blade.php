@extends('layouts.blog')

@section('doc_title', 'Register - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4 overflow-auto">
        <h2>Register</h2>
    </div>


    <div class="d-flex justify-content-center">
        <form method="POST" action="{{ route('register') }}" class="col-md-10 p-5 border rounded">
            @csrf
            <h5 class="form-label-group text-center">Provide Your details to get registered.</h5>

            <div class="form-label-group">
                <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name"
                       value="{{ old('name') }}" placeholder="Name" autocomplete="name" required autofocus />
                <label for="name">Name</label>
                @error('name')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-label-group">
                <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email"
                       value="{{ old('email') }}" placeholder="Email Address" autocomplete="email" required />
                <label for="email">E-Mail Address</label>
                @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-label-group">
                <input class="form-control @error('password') is-invalid @enderror" id="password" type="password"
                       name="password" value="{{ old('password') }}" placeholder="Password" autocomplete="new-password"
                       required />
                <label for="password">Password</label>
                @error('password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-label-group">
                <input class="form-control" id="password-confirm" type="password" name="password_confirmation"
                       placeholder="Confirm Password" required />
                <label for="password-confirm">Confirm Password</label>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>

            <div class="text-center mt-5">
                Already a member? <a href="{{ route('login') }}" class="text-decoration-none">Log In</a>
            </div>
        </form>
    </div>
@endsection
