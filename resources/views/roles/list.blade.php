@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Roles</h1>
        <a href="\role/create" class="btn btn btn-primary">Create</a>
    </div>

    <!-- Role List -->
    <div class="card card-body">
        <form>
            @csrf
            <table id="roles_table" class="table table-hover table-condensed" style="width:100%">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Role</th>
                    <th>Permission Count</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </form>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        // Script for Yajra DataTables
        $(document).ready(function () {
            $('#roles_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('role.list') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'count', name: 'count'},
                    {data: 'action', name: 'action', orderable: false},
                ]
            });
        });

        <!-- Script for Sweet Alert -->
        function deleteRole(name, form) {
            swal({
                title: "Delete Role : " + name,
                text: "Are you sure to delete this role?",
                icon: "warning",
                buttons: {
                    cancel: true,
                    confirm: {
                        text: "OK",
                        value: true,
                        visible: true,
                        className: "",
                        closeModal: false,
                    }
                },
                dangerMode: true,
            }).then((value) => {
                if (value) {
                    $.ajax({
                        url: '\\role/delete/' + name,
                        type: "POST",
                        data: new FormData(form),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (success) {
                            swal({
                                title: "Delete Role : " + name,
                                text: `Role '${name}' deleted successfully`,
                                icon: "success",
                                buttons: {
                                    cancel: {
                                        text: "Close",
                                        visible: true,
                                        closeModal: true,
                                    }
                                },
                                timer: 2000,
                            });
                            $('#roles_table').DataTable().ajax.reload();
                        },
                        error: function (error) {
                            swal({
                                title: 'Could not delete the Role',
                                text: `Error :  ${error}`,
                                icon: "danger",
                                buttons: {
                                    cancel: {
                                        text: "Close",
                                        visible: true,
                                        closeModal: true,
                                    }
                                },
                                timer: 2000,
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection
