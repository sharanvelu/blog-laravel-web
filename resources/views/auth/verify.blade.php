@extends('layouts.blog')

@section('doc_title', 'Verify - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4 overflow-auto">
        <h2>Verify Your Email Address</h2>
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-md-10 p-5 border rounded">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('Check your Spam inbox also.') }}
            {{ __('Didn\'t receive the email?') }},

            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button class="btn btn-lg btn-primary btn-block" type="submit">Click to request another</button>
            </form>
        </div>
    </div>
@endsection
