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

    <!-- My own Custom Styles -->
    <link rel="stylesheet" href="\blog/custom/custom-styles.css">

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

            @hasrole('SuperAdmin')
            <li class="nav-item">
                <a class="nav-link" href="\home">
                    <i class="fas fa-fw fa-paint-roller"></i>
                    <span>Allow New User</span>
                </a>
            </li>
            @endhasrole

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                POST
            </div>

        @can('create-post')
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
        @endcan

        <!-- Nav Item - Show All Post -->
            <li class="nav-item">
                <a class="nav-link" href="\post/home">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>Show all Post</span></a>
            </li>


            @hasanyrole('SuperAdmin|Admin')
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

            @endhasanyrole

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
                <div class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100">
                    <div class="input-group">
                        <h1 class="h3">Sharan's Blog</h1>
                    </div>
                </div>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto mr-5">
                    <li class="nav-item"><a href="\post/home" class="nav-link text-gray-700">Home</a></li>
                    <li class="nav-item"><a href="#contact" class="nav-link text-gray-700">Contact</a></li>

                    @foreach($login_data as $data)
                            <li class="nav-item">
                                <a href="{{ $data->href }}" class="nav-link text-gray-700"
                                @if($data->name =="Logout") onclick="event.preventDefault(); logout()" @endif>
                                    {{ $data->name }}</a>
                            </li>
                    @endforeach

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid" id="page_content" style="height: 85vh">

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

<!-- Logout form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST"
      style="display: none;">
    @csrf
</form>

@yield('script')

<!-- CDN for Sweet Alert -->
<script src="\blog/custom/sweetalert/sweetalert.min.js"></script>

<!-- My own Custom Script -->
<script src="\blog/custom/custom-script.js"></script>

</body>

</html>

