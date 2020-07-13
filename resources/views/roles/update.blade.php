@extends('layouts.app')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Update Roles</h1>
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
    <form method="POST" action="\role/update/{{ $role->name }}"
          class="content col-11 mx-auto my-3">
        @csrf

        <div class="form-group row">
            <label class="col-md-2 my-auto">Role Name : </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="role_name" required disabled
                       value="{{ $role->name }}" />
            </div>
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
@endsection
