@extends('layouts.blog')

@section('doc_title', 'Create Role - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center mb-4 justify-content-between">
        <h2>Create Roles</h2>
    </div>

    @if ($errors->any())
        <div class="d-flex justify-content-center">
            <div class="alert alert-danger col-8">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Role Create Form -->
    <form method="POST" action="\role/add" class="content col-md-12 mx-auto my-3 p-5 border rounded shadow">
        @csrf

        <div class="form-label-group">
            <input class="form-control" placeholder="Role Name"
                   id="role_name" type="text" name="role_name" required />
            <label for="role_name">Role Name</label>
        </div>

        <div class="card my-2">
            <div class="card-header">Assign Permissions</div>
            <div class="card-body mx-auto col-lg-5">
                @foreach( Spatie\Permission\Models\Permission::all() as $permission )
                    <p>
                        <input type="checkbox" name="{{ $permission->name }}"
                               value="{{ $permission->name }}" id="{{ $permission->name }}"/>
                        <label for="{{ $permission->name }}" class="card-text">
                            {{ ucwords(str_replace('-', ' ', $permission->name)) }}
                        </label>
                    </p>
                @endforeach
                <hr>
                <input type="checkbox" id="select_all"/>
                <label for="select_all">Select All</label>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-8 offset-md-4 text-md-right">
                <button type="submit" class="btn btn-primary">Create</button>
                <a class="btn btn-outline-secondary ml-1" href="{{ __("\\role/list") }}">Cancel</a>
            </div>
        </div>
    </form>

    <!-- Divider -->
    <hr class="mb-5 mt-lg-5">

    <!-- Related Links -->
    <div class="mb-4">
        <h3>Related Links</h3>
    </div>

    <a class="m-3 text-decoration-none" href="{{ route('create') }}">
        <div class="dashboard-element dashboard-element-success">Create Post</div>
    </a>

    <a class="m-3 text-decoration-none" href="\post/home">
        <div class="dashboard-element dashboard-element-primary">Show All Post</div>
    </a>

    <a class="m-3 text-decoration-none" href="\role/list">
        <div class="dashboard-element dashboard-element-secondary">List Roles</div>
    </a>
@endsection
