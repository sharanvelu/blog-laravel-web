@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Assign Roles to Users</h1>
        <a href="\role/create" class="btn btn btn-primary">Create Role</a>
    </div>

    <div class="card p-3">
        <form class="m-3">
            @csrf
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">User Name</label>
                <div class="col-md-4">
                    <select class="col-md-12" id="user_select" name="user_name">
                        @foreach(App\User::all() as $user)
                            <option>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Role Name</label>
                <div class="col-md-4 my-auto">
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

        <form class="col-10 align-self-center border p-3">
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

    <div class="modal fade" id="edit_user_role_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update the Role</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="m-3">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">User Name</label>
                            <div>
                                <input class="border-0 bg-transparent" id="user_select_modal"
                                       name="user_name" value="" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Role Name</label>
                            <select id="role_select_modal" name="role_name" class="col-md-12">
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
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" id="cancel_user_role_modal"
                                type="button" data-dismiss="modal">Cancel
                        </button>
                        <button type="button" class="my-auto btn btn-primary" id="update_button_modal"
                                onclick="assignDetachRole(this.form, 'sync', this.form.user_name.value, this.form.role_name.value)">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
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
            $('#user_select_modal').val(user_name);
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
