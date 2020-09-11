<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('doc_title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Sharan">

    <!-- Title Bar Icon -->
    <link rel="shortcut icon" href="\blog/images/titlebar_logo.png"/>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <!-- Bootstrap CDN -->
    <link crossorigin="anonymous" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" rel="stylesheet">
    <!-- JS, Popper.js, and jQuery -->
    <script crossorigin="anonymous"
            integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
          integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">

    <!-- Charting library -->
    <script src="\blog/chart/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="\blog/chart/chartisan_echarts.js"></script>
    <!-- Chart Custom Script -->
    <script src="\blog/chart/chart.js"></script>

    <!-- My own Custom Styles -->
    <link rel="stylesheet" href="\blog/custom/style.css">

    <!-- Google Adsense -->
    <script data-ad-client="ca-pub-3601562801028392" async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

</head>
<body>
<!-- Nav Bar Begins -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container py-1">
        <a class="navbar-brand" href="\post/home">
            Sharan
        <!--<img class="mr-3" src="{{ $site_logo }}" height="70px">-->
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav"
                aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">Menu
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" id="nav_item_home"><a href="\post/home" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
                @foreach($login_data as $data)
                    <li class="nav-item" id="nav_item_{{ $data->name }}">
                        <a href="{{ $data->href }}" class="nav-link"
                           @if($data->name =="Logout") onclick="event.preventDefault(); logout()" @endif>
                            {{ $data->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
<div class="scroll-status-bar"></div>
<!-- Nav Bar Ends -->

<div class="m-3 pt-4 pb-5"></div> <!-- Space -->

<!-- Main Content Begins -->
<div class="container">
    <div class="row">

        <!-- Content Begins -->
        <div class="col-lg-8 mb-5 mb-lg-0">
            @yield('content')
        </div>
        <!-- Content Ends -->

        <!-- Side Bar Begins -->
        <div class="col-lg-4">

            <!-- SideBar Search Begins -->
            <form class="sidebar-elem position-relative" id="sidebar_search">
                <input type="text" class="form-control" placeholder="Type a keyword" id="sidebar_search_input"
                       name="key" onkeyup="sidebarSearch()"/>
                <span onclick="document.getElementById('sidebar_search').submit();" class="search-icon">
                        <i class="fas fa-search"></i></span>
                <label for="sidebar_search_input"></label>
            </form>
            <!-- SideBar Search Ends -->

            <!-- Recent Post Begins -->
            <div class="sidebar-elem">
                <h4>Recent Post</h4>
                @foreach($recent_posts as $latest_post)
                    <a href="\post/{{ $url = $users->find($latest_post->user_id)->name.'/'.str_replace('?','-', str_replace(' ', '-', $latest_post->post_title)).'-'.$latest_post->id }}"
                       class="text-decoration-none">
                        <div class="row post-sm">
                            <div class="col-3 col-md-2 col-lg-4">
                                <div style="background-image: url('{!! asset('storage/' . $latest_post->image) !!}')"
                                     class="post-img"></div>
                            </div>
                            <div class="col-9 col-md-10 col-lg-8">
                                <div class="post-title">{{ $latest_post->post_title }}
                                </div>
                                <div class="text-secondary"><span class="mr-1"><i class="far fa-user"></i></span>
                                    {{ $users->find($latest_post->user_id)->name }}
                                </div>
                                <div class="text-secondary"><span class="mr-1"><i
                                            class="far fa-calendar-alt"></i></span>
                                    {{ date("M j, Y ", strtotime($latest_post->created_at)) }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <!-- Recent Post Ends -->

            <!-- Popular Tags Begins -->
            <div class="sidebar-elem">
                <h4>Popular Tags</h4>
                @foreach($popular_tags as $popular_tag)
                    <li>
                        <a href="\post/tag/{{ $popular_tag->tag_name }}" class="text-decoration-none">
                            <div>{{ $popular_tag->tag_name }}
                                <span>Post Count : {{ $popular_tag->count }} <i class="fas fa-angle-right"></i></span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </div>
            <!-- Popular Tags Ends -->

            <!-- Tag Cloud Begins -->
            <div class="sidebar-elem">
                <h4>Tag Cloud</h4>
                <div class="tag-cloud">
                    @foreach($tag_cloud->take(30) as $tag)
                        <a href="\post/tag/{{ $tag->name }}" class="text-decoration-none">
                            {{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
            <!-- Tag Cloud Ends -->

            <!-- Search by month Begins -->
            <div class="sidebar-box ftco-animate">
                <h3>Filter posts by month</h3>
                <form class="search-form" action="\search/date" method="post">
                    @csrf
                    <div class="form-group"><input type="month" name="key" class="form-control"></div>
                    <div class="form-group">
                        <button class="custom-button-secondary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Search by month Ends -->
    </div>
    <!-- Side Bar Ends -->

</div>
<!-- Main Content Ends -->

<!-- Logout Modal-->
<form id="logout-form" action="{{ route('logout') }}" method="POST"
      style="display: none;">
    @csrf
</form>

<!-- ---- Footer Start ---- -->
<footer class="bg-secondary">
    <div class="text-center text-light py-3">
        <i class="fas fa-wind fa-2x fa-flip-horizontal"></i>
        <span class="h3 mx-3">Sharan</span>
        <i class="fas fa-wind fa-2x"></i>
    </div>
    <div class="container pb-3 h3 mb-0">
        <ul class="list-unstyled row m-0 justify-content-center">
            <li><a href="#" class="text-dark"><i class="fab fa-twitter"></i></a></li>
            <li class="mx-3"><a href="#" class="text-dark"><i class="fab fa-facebook"></i></a></li>
            <li><a href="#" class="text-dark"><i class="fab fa-instagram"></i></a></li>
        </ul>
    </div>
</footer>
<!-- ---- Footer Ends ---- -->

<!-- ---- Script Begins ---- -->
<!-- CDN for Sweet Alert -->
<script src="\blog/sweetalert/sweetalert.min.js"></script>

<!-- My own Custom Script -->
<script src="\blog/custom/script.js"></script>

@yield('script')

<!-- ---- Script Ends ---- -->

</body>
</html>
