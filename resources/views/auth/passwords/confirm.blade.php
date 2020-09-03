@extends('layouts.app')

@section('doc_title', 'Confirm Password - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4 overflow-auto">
        <h2>Confirm Password</h2>
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-md-10 p-5 border rounded">

            <h5 class="form-label-group text-center">Please confirm your password before continuing.</h5>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="form-label-group">
                    <input class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                           id="password" type="password" name="password" required
                           autocomplete="current-password"/>
                    <label for="password">Password</label>
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button class="btn btn-lg btn-primary btn-block" type="submit">Confirm Password</button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Confirm Password') }}</div>

                    <div class="card-body">
                        {{ __('Please confirm your password before continuing.') }}

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Confirm Password') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
