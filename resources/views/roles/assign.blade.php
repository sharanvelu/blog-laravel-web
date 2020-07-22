@extends('layouts.blog')

@section('doc_title', 'Assign Role to User - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center mb-4 justify-content-between">
        <h1>Assign Roles to users</h1>
        <a href="\role/create" class="custom-button-success">Create Role</a>
    </div>

    <form class="col-md-12">
        @csrf
        <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">User Name</label>
            <div class="col-md-5">
                <select class="col-md-12" id="user_select" name="user_name">
                    @foreach(App\User::all() as $user)
                        <option>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Role Name</label>
            <div class="col-md-5 my-auto">
                <select class="col-md-12" id="role_select" name="role_name">
                    @foreach(Spatie\Permission\Models\Role::all() as $role)
                        @if( $role->name != 'SuperAdmin' )
                            @if(Auth::user()->hasRole(['Admin']) && $role->name == 'Admin')
                            @else
                                <option>{{ $role->name }}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="button" class="ml-4 my-auto btn btn-secondary" id="add_button"
                    onclick="assignDetachRole(this.form, 'assign', this.form.user_name.value, this.form.role_name.value)">
                Add
            </button>
        </div>
    </form>

    <div class="card card-body">
        <form>
            @csrf
            <table id="user_role_table" class="table table-hover table-condensed" style="width:100%">
                <thead>
                <tr>
                    <th>User Name</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </form>
    </div>

    <div id="csrf_form">
        <form>@csrf
            <input type="text" value="" hidden id="csrf_form_user_name" name="user_name">
            <button type="button" hidden id="csrf_form_button" onclick="editUserRole(this.form)"></button>
        </form>
    </div>


    <!-- Divider -->
    <hr class="mb-5 mt-lg-5">
    <!-- Related Links -->
    <div class="mb-4">
        <h3>Related Links</h3>
    </div>

    <a class="m-3" href="{{ route('create') }}">
        <div class="dashboard-element dashboard-element-success">Create Post</div>
    </a>

    <a class="m-3" href="\post/home">
        <div class="dashboard-element dashboard-element-primary">Show All Post</div>
    </a>

    <a class="m-3" href="\role/list">
        <div class="dashboard-element dashboard-element-secondary">List Roles</div>
    </a>

@endsection

@section('script')
    <!-- CDN for Select 2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <!-- CDN for Yajra DataTables -->
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        // Script for Yajra DataTables
        $(document).ready(function () {
            $('#user_role_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user_role.list') }}",
                columns: [
                    {data: 'user_name', name: 'user_name'},
                    {data: 'role', name: 'role'},
                    {data: 'action', name: 'action', orderable: false},
                ]
            });
        });

        function assignDetachRole(form, action, user_name, role_name) {
            data = new FormData(form);
            data.append("user_name", user_name);
            data.append("role_name", role_name);
            buttonDisableTrue();
            $.ajax({
                url: '\\role/user/' + action,
                type: "POST",
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (success) {
                    $('#cancel_user_role_modal').trigger('click');
                    buttonDisableFalse();
                    swal({
                        title: success,
                        text: 'Role : ' + role_name + ' -> User : ' + user_name,
                        icon: "success",
                        buttons: {
                            cancel: {
                                text: "Close",
                                visible: true,
                                closeModal: true,
                            }
                        },
                    });
                    $('#user_role_table').DataTable().ajax.reload();
                },
                error: function (error) {
                    buttonDisableFalse();
                    swal({
                        title: `Could not define role to this user`,
                        text: `Error :  ${error}`,
                        icon: "danger",
                        buttons: {
                            cancel: {
                                text: "Close",
                                visible: true,
                                closeModal: true,
                            }
                        },
                    });
                }
            });
        }

        function updateUserRole(user_name) {
            $('#csrf_form_user_name').val(user_name);
            $('#csrf_form_button').trigger('click');
        }

        function editUserRole(form) {
            swal({
                title: 'Update the role',
                text: 'User Name : ' + form.user_name.value,
                icon: 'info',
                buttons: {
            @foreach(Spatie\Permission\Models\Role::all() as $role)
            @if( $role->name != 'SuperAdmin' )
            @if(Auth::user()->hasRole(['Admin']) && $role->name == 'Admin')
            @else
            {{ $role->name }}:
            {
                text: '{{ $role->name }}',
                    value
            :
                '{{ $role->name }}'
            }
        ,
            @endif
                @endif
                @endforeach
                cancel: {
                text: "Close",
                    visible
            :
                true,
                    closeModal
            :
                true,
            }
        }
        }).
            then((value) => {
                if (value) {
                    assignDetachRole(form, 'sync', form.user_name.value, value);
                }
            })
        }

        function buttonDisableTrue() {
            $('#update_button_modal').prop("disabled", true);
            $('#add_button').prop("disabled", true);
            $('#del_button').prop("disabled", true);
        }

        function buttonDisableFalse() {
            $('#add_button').prop("disabled", false);
            $('#update_button_modal').prop("disabled", false);
            $('#del_button').prop("disabled", false);
        }

        $(document).ready(function () {
            $('#user_select').select2();
            $('#role_select').select2();
            $('#role_select_modal').select2();
        });

    </script>
@endsection
