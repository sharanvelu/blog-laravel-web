@extends('layouts.blog')

@section('doc_title', 'Dashboard - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4">
        <h1>Dashboard</h1>
    </div>

    @can('create-post')
    <a class="m-3" href="{{ route('create') }}">
        <div class="dashboard-element dashboard-element-success">Create Post</div>
    </a>

    <a class="m-3" href="\post/{{ Auth::User()->name }}">
        <div class="dashboard-element dashboard-element-secondary">Show My Post</div>
    </a>
    @endcan

    <a class="m-3" href="\post/home">
        <div class="dashboard-element dashboard-element-primary">Show All Post</div>
    </a>

    @hasrole('SuperAdmin')
    <a class="m-3" href="\role/list">
        <div class="dashboard-element dashboard-element-info">List Roles</div>
    </a>

    <a class="m-3" href="\role/assign">
        <div class="dashboard-element dashboard-element-secondary">Assign Roles</div>
    </a>

    <a class="m-3" href="">
        <div class="dashboard-element dashboard-element-danger">
            <!-- Default switch -->
            <div class="custom-control custom-switch">
                <form id="new_user_toggle_form">
                    @csrf
                    <input type="checkbox" class="custom-control-input" id="new_user_toggle"
                           onclick="NewUserToggle(this.form)"
                        {{ DB::table('user_register')->first()->allow_register ? 'checked' : '' }} />
                    <label class="custom-control-label" for="new_user_toggle">Allow New User</label>
                </form>
            </div>
        </div>
    </a>
    @endhasrole

    @hasrole('Admin')
    <a class="m-3" href="\role/list">
        <div class="dashboard-element dashboard-element-info">List Roles</div>
    </a>

    <a class="m-3" href="\post/assign">
        <div class="dashboard-element dashboard-element-secondary">Assign Roles</div>
    </a>
    @endhasrole
@endsection
