<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('doc_title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel = "icon" href ="\blog/images/titlebar_logo.png" type = "image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="\blog/css/animate.css">
    <link rel="stylesheet" href="\blog/css/ionicons.min.css">
    <link rel="stylesheet" href="\blog/css/icomoon.css">
    <link rel="stylesheet" href="\blog/css/style.css">

    <!-- Custom icons for template-->
    <link href="\vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- My own Custom Styles -->
    <link rel="stylesheet" href="\blog/custom/custom-styles.css">

    <script data-ad-client="ca-pub-3601562801028392" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

</head>
<body>

<nav class="navbar px-md-0 navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="\post/home">
            <img class="m-n3" src="{{ $site_logo }}" height="80px">
            {{--Sharan's<i> Blog</i>--}}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
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
<!-- END nav -->

<!-- Landing Screen -->
<section class="hero-wrap hero-wrap-2 js-fullheight"
         style="max-height: 120px;">
    <div class="overlay"></div>
</section>

<!-- Beginnning of the content -->
<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ftco-animate">

                @yield('content')

            </div>

            <!-- Side Bar -->
            <div class="col-lg-4 sidebar pl-lg-5 ftco-animate">
                <!-- SideBar Search -->
                <div class="sidebar-box ftco-animate">
                    <form class="search-form" action="#" method="get" id="sidebar_search">
                        <div class="form-group">
                            <span onclick="document.getElementById('sidebar_search').submit();"><i
                                    class="icon icon-search"></i></span>
                            <input type="text" name="key" class="form-control"
                                   placeholder="Type a keyword and hit enter"
                                   onkeyup="sidebarSearch()">
                        </div>
                    </form>
                </div>

                <!-- SideBar Recent Post -->
                <div class="sidebar-box ftco-animate">
                    <h3>Recent Post</h3>
                    @foreach($recent_posts as $latest_post)
                        <div class="block-21 mb-4 d-flex">
                            <a class="img mr-4 rounded"
                               style="background-image: url('{{ asset('storage/' . $latest_post->image) }}');"
                               href="\post/{{ $url = $users->find($latest_post->user_id)->name.'/'.str_replace('?','-', str_replace(' ', '-', $latest_post->post_title)).'-'.$latest_post->id }}"></a>
                            <div class="text">
                                <h3 class="heading"><a
                                        href="\post/{{ $url }}">
                                        {{ $latest_post->post_title }}...</a>
                                </h3>
                                <div class="meta">
                                    <div><a><span class="icon-calendar"></span>
                                            {{ date("M j, Y ", strtotime($latest_post->created_at)) }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- SideBar Popular Tags -->
                <div class="sidebar-box ftco-animate">
                    <div class="categories">
                        <h3>Popular Tags</h3>
                        @foreach($popular_tags as $popular_tag)
                            <li>
                                <a href="\post/tag/{{ $popular_tag->tag_name }}">
                                    {{ $popular_tag->tag_name }}
                                    <span class="mr-lg-5">Post Count : {{ $popular_tag->count }}</span>
                                    <span class="ion-ios-arrow-forward"></span>
                                </a></li>
                        @endforeach
                    </div>
                </div>

                <!-- TagCloud -->
                <div class="sidebar-box ftco-animate">
                    <h3>Tag Cloud</h3>
                    <div class="tagcloud">
                        @foreach($tag_cloud->take(30) as $tag)
                            <a href="\post/tag/{{ $tag->name }}" class="tag-cloud-link">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>

                <!-- Posts by month -->
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
            <!-- End of Side Bar -->
        </div>
    </div>
</section>

<!-- Logout Modal-->
<form id="logout-form" action="{{ route('logout') }}" method="POST"
      style="display: none;">
    @csrf
</form>

<!-- Footer Begins -->
<footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
        <div class="row mb-5">
            <!-- About -->
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="logo"><a href="\post/home">Sharan's<span>Blog</span>.</a></h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there
                        live the blind texts.</p>
                    <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                        <li class="ftco-animate"><a><span class="icon-twitter"></span></a></li>
                        <li class="ftco-animate"><a><span class="icon-facebook"></span></a></li>
                        <li class="ftco-animate"><a><span class="icon-instagram"></span></a></li>
                    </ul>
                </div>
            </div>
            <!-- End of About -->

            <!-- Latest Post -->
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">latest News</h2>
                    @foreach($recent_posts->take(2) as $latest_post)
                        <div class="block-21 mb-4 d-flex">
                            <a class="img mr-4 rounded"
                               style="background-image: url('{{ asset('storage/' . $latest_post->image) }}');"
                               href="\post/{{ $url = $users->find($latest_post->user_id)->name.'/'.str_replace('?','-', str_replace(' ', '-', $latest_post->post_title)).'-'.$latest_post->id }}"></a>
                            <div class="text">
                                <h3 class="heading"><a
                                        href="\post/{{ $url }}">
                                        {{ ($latest_post->post_title) }}</a>
                                </h3>
                                <div class="meta">
                                    <div><a><span class="icon-calendar"></span>
                                            {{ date("M j, Y ", strtotime($latest_post->created_at)) }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- End of Latest Post -->

            <!-- Information -->
            <div class="col-md">
                <div class="ftco-footer-widget mb-4 ml-md-5">
                    <h2 class="ftco-heading-2">Information</h2>
                    <ul class="list-unstyled">
                        <li><a href="\post/home" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Home</a>
                        </li>
                        <li><a href="\post/home" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Articles</a>
                        </li>
                        <li><a href="#contact" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Contact</a>
                        </li>
                        @auth
                            <li><a href="\home" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Dashboard</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
            <!-- End of Information -->

            <!-- Contacts -->
            <div class="col-md" id="contact">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Have a Questions?</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li><span class="icon icon-map-marker"></span><span class="text">2/34, S.Pudhupalayam, P.Velur(TK), Namakkal(DT), 637212</span>
                            </li>
                            <li><a><span class="icon icon-phone"></span><span
                                        class="text">+91 98432 07572</span></a></li>
                            <li><a><span class="icon icon-envelope"></span><span class="text">mail@sharanvelu.xyz</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="\blog/js/jquery.min.js"></script>
<script src="\blog/js/bootstrap.min.js"></script>
<script src="\blog/js/jquery.waypoints.min.js"></script>
<script src="\blog/js/jquery.animateNumber.min.js"></script>
<script src="\blog/js/main.js"></script>

<!-- CDN for Sweet Alert -->
<script src="\blog/custom/sweetalert/sweetalert.min.js"></script>

@yield('script')

<!-- My own Custom Script -->
<script src="\blog/custom/custom-script.js"></script>

</body>
</html>
