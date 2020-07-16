<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('head_title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="\blog/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="\blog/css/animate.css">

    <link rel="stylesheet" href="\blog/css/owl.carousel.min.css">
    <link rel="stylesheet" href="\blog/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="\blog/css/magnific-popup.css">

    <link rel="stylesheet" href="\blog/css/aos.css">

    <link rel="stylesheet" href="\blog/css/ionicons.min.css">

    <link rel="stylesheet" href="\blog/css/flaticon.css">
    <link rel="stylesheet" href="\blog/css/icomoon.css">
    <link rel="stylesheet" href="\blog/css/style.css">

    <!-- CDN for Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Custom fonts for this template-->
    <link href="\vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- My own Custom Styles -->
    <link rel="stylesheet" href="\blog/custom/custom-styles.css">

</head>
<body>

<nav class="navbar px-md-0 navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="\post/home">Sharan's<i> Blog</i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="\post/home" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="\post/home" class="nav-link">Articles</a></li>
                <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
                @auth
                    <li class="nav-item"><a href="\home" class="nav-link">Dashboard</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<!-- END nav -->

@yield('content')

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
                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                        <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                        <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                    </ul>
                </div>
            </div>
            <!-- End of About -->

            <!-- Latest Post -->
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">latest News</h2>
                    @foreach(App\Post::latest()->take(2)->get() as $latest_post)
                        <div class="block-21 mb-4 d-flex">
                            <a class="img mr-4 rounded"
                               href="\post/{{ $latest_post->user->name }}/{{ str_replace(' ', '-', $latest_post->post_title) }}-{{ $latest_post->id }}"
                               style="background-image: url('\\{{ $latest_post->image }}');"></a>
                            <div class="text">
                                <h3 class="heading"><a
                                        href="\post/{{ $latest_post->user->name }}/{{ str_replace(' ', '-', $latest_post->post_title) }}-{{ $latest_post->id }}">
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
                            <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span>
                            </li>
                            <li><a href="#"><span class="icon icon-phone"></span><span
                                        class="text">+2 392 3929 210</span></a></li>
                            <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- loader -->
{{--<div id="ftco-loader" class="show fullscreen">--}}
{{--    <svg class="circular" width="48px" height="48px">--}}
{{--        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>--}}
{{--        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"--}}
{{--                stroke="#F96D00"/>--}}
{{--    </svg>--}}
{{--</div>--}}

<script src="\blog/js/jquery.min.js"></script>
<script src="\blog/js/jquery-migrate-3.0.1.min.js"></script>
<script src="\blog/js/popper.min.js"></script>
<script src="\blog/js/bootstrap.min.js"></script>
<script src="\blog/js/jquery.easing.1.3.js"></script>
<script src="\blog/js/jquery.waypoints.min.js"></script>
<script src="\blog/js/jquery.stellar.min.js"></script>
<script src="\blog/js/owl.carousel.min.js"></script>
<script src="\blog/js/jquery.magnific-popup.min.js"></script>
<script src="\blog/js/aos.js"></script>
<script src="\blog/js/jquery.animateNumber.min.js"></script>
<script src="\blog/js/scrollax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="\blog/js/google-map.js"></script>
<script src="\blog/js/main.js"></script>

<!-- My own Custom Script -->
<script src="\blog/custom/custom-script.js"></script>

</body>
</html>
