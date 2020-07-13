@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    @if(Auth::user()->hasAnyRole(['SuperAdmin', 'Admin', 'Writer']))
    <div class="row">
        <a class="col-xl-3 col-md-6 mb-4 card-link" href="{{ route('create') }}">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="row no-gutters align-items-center card-body">
                    <div class="h5 mb-0 font-weight-bold text-success">Create Post</div>
                </div>
            </div>
        </a>

        <a class="col-xl-3 col-md-6 mb-4 card-link" href="\post/{{ Auth::user()->name }}">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="row no-gutters align-items-center card-body">
                    <div class="h5 mb-0 font-weight-bold text-primary">Show My Post</div>
                </div>
            </div>
        </a>
        @endif

        <a class="col-xl-3 col-md-6 mb-4 card-link" href="\post/home">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="row no-gutters align-items-center card-body">
                    <div class="h5 mb-0 font-weight-bold text-info">Show All Post</div>
                </div>
            </div>
        </a>
    </div>
@endsection
