<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Custom styles for this template-->
    <link href="\css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="\vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="\vendor/jquery/jquery.min.js"></script>
    <script src="\vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="\vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="\js/sb-admin-2.min.js"></script>

    <!-- CDN for Yajra DataTables -->
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <!-- CDN for Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- CDN for Select 2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <!-- My own Custom Styles -->
    <link rel="stylesheet" href="\blog/custom/custom-styles.css">

    @yield('head')

</head>

<body id="page-top">

<!-- Page Wrapper Beginning -->
<div id="wrapper">

@auth
    <!-- Sidebar Beginning -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="ml-4 mt-4 d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-text mx-3">
                    {{ Auth::user()->name }}
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    {{ __('Dashboard') }}
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                POST
            </div>

        @if(Auth::user()->hasPermissionTo('create-post'))
            <!-- Nav Item - Create Post -->
                <li class="nav-item">
                    <a class="nav-link" href="\post/new">
                        <i class="fas fa-fw fa-crown"></i>
                        <span>Create Post</span></a>
                </li>
                <!-- Nav Item - Show My Post -->
                <li class="nav-item">
                    <a class="nav-link" href="\post/{{ Auth::user()->name }}">
                        <i class="fas fa-fw fa-desktop"></i>
                        <span>Show My Post</span></a>
                </li>
        @endif

        <!-- Nav Item - Show All Post -->
            <li class="nav-item">
                <a class="nav-link" href="\post/home">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>Show all Post</span></a>
            </li>


        @if(Auth::user()->hasAnyRole(['SuperAdmin', 'Admin']))
            <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Role
                </div>

                <!-- Roles Sidebar -->
                <li class="nav-item">
                    <a class="nav-link" href="\role/list">
                        <i class="fas fa-fw fa-paint-roller"></i>
                        <span>Roles</span></a>
                </li>

                <!-- Assign Role Sidebar -->
                <li class="nav-item">
                    <a class="nav-link" href="\role/assign">
                        <i class="fas fa-fw fa-paint-roller"></i>
                        <span>Assign Role</span></a>
                </li>
            @endif

        </ul>
        <!-- End of Sidebar -->
@endauth

<!-- Content Wrapper Beginning -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow ">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Title -->
            {{--                <div class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100">--}}
            {{--                    <div class="input-group">--}}
            {{--                        <h1 class="h3">Blog Posts</h1>--}}
            {{--                    </div>--}}
            {{--                </div>--}}

            <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto mr-5">

                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-gray-700" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-gray-700" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-gray-700" href="#" data-toggle="modal" data-target="#logoutModal">
                                {{ __('Logout') }}
                            </a>
                        </li>
                    @endguest

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid" id="page_content">

                @yield('content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll-to-Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Are you sure to end your current session?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script for Edit or Delete Modal -->
<script>

    // Function to Open modal for EDIT Post
    function edit_function(data) {
        $("#modalTitle").html("You are about to Edit");
        $("#formId").attr("action", "\\post/update/" + data.id);
        $("#PostTitleInput").val(data.post_title).prop("disabled", false);
        $("#PostDescriptionInput").val(data.post_description).prop("disabled", false);
        $("#PostDescriptionDiv").show();
        $("#PostDescriptionDelDiv").hide();
        $("#PostImageInput").val("").show();
        $("#editSubmitBtn").prop("disabled", false);
        $('#editSubmitBtn').show();
        $('#delSubmitBtn').hide();
        $("#PostImageDisp").attr("src", "\\" + data.image);
        $("#PostImageDiv").show();
        if (data.image == "") {
            $("#PostImageDisp").hide();
        } else {
            $("#PostImageDisp").show();
        }
        froala();
    }

    // Function to Open modal for DELETE Post
    function delete_function(data) {
        $("#modalTitle").html("Are you sure to Delete");
        $("#formId").attr("action", "\\post/delete/" + data.id);
        $("#PostTitleInput").val(data.post_title).prop("disabled", true);
        $("#PostDescriptionDiv").hide();
        $("#PostDescriptionDelDiv").html(data.post_description).show();
        $("#delSubmitBtn").prop("disabled", false);
        $('#editSubmitBtn').hide();
        $('#delSubmitBtn').show();
        $("#PostImageDisp").show().attr("src", "\\" + data.image);
        $("#PostImageInput").hide();
        if (data.image == "") {
            $("#PostImageDiv").hide();
        } else {
            $("#PostImageDiv").show();
        }
    }

    // Function to perform Edit or Delete action through AJAX request
    function AjaxCall(form) {
        $("#editSubmitBtn").prop("disabled", true);
        $("#delSubmitBtn").prop("disabled", true);
        $.ajax({
            url: form.action,
            type: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            success: function ($success) {
                $("#cancel_modal").trigger("click");
                $("#page_content_title").load(location.href + " #page_content_title");
                $("#page_content_desc").load(location.href + " #page_content_desc");
                $("#page_content_image").load(location.href + " #page_content_image");
            },
            error: function ($error) {
                alert("Error : " + $error.status + " ( " + $error.statusText + " )");
                $("#editSubmitBtn").prop("disabled", false);
                $("#delSubmitBtn").prop("disabled", false);
            }
        });
    }

</script>

@yield('script')

<!-- My own Custom Script -->
<script src="\blog/custom/custom-script.js"></script>

</body>

</html>

