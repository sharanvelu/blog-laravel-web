@extends('layouts.blog')

@section('doc_title', 'List Role - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center mb-4 justify-content-between">
        <h2>List Roles</h2>
        <a href="\role/create" class="custom-button-success text-decoration-none">Create</a>
    </div>

    <!-- Role List -->
    <div class="p-5 border rounded shadow">
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

    <a class="m-3 text-decoration-none" href="\role/assign">
        <div class="dashboard-element dashboard-element-secondary">Assign Roles</div>
    </a>

@endsection

@section('script')
    <!-- CDN for Yajra DataTables -->
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

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
