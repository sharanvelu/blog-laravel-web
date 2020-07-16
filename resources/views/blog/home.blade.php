@extends('layouts.blog')

@section('head_title', 'Sharan\'s Blog')

@section('content')

    <!-- Landing Screen -->
    <div class="hero-wrap js-fullheight" style="background-image: url('\\blog/images/main_bg.jpg');"
         data-stellar-background-ratio="0.4">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start"
                 data-scrollax-parent="true">
                <div class="col-md-12 ftco-animate">
                    <h2 class="subheading">Hello! Welcome to</h2>
                    <h1 class="mb-4 mb-md-0">My blog</h1>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="text">
                                <div class="mouse">
                                    <div class="mouse-icon" style="cursor: default">
                                        <div class="mouse-wheel"><span class="ion-ios-arrow-round-down"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row d-flex">
                <!-- Blog Post -->
                @foreach($posts as $post)
                    <div class="col-md-4 d-flex ftco-animate custom-border-0">
                        <div class="blog-entry justify-content-end">
                            <a href="\post/{{ $post->user->name }}/{{ str_replace(' ', '-', $post->post_title) }}-{{ $post->id }}"
                               class="block-20" style="background-image: url('\\{{ $post->image }}');">
                            </a>
                            <div class="text p-4 float-right d-block">
                                <div class="topper d-flex align-items-center">
                                    <div class="one py-2 pl-3 pr-1 align-self-stretch">
                                        <span class="day">{{ date("j", strtotime($post->created_at)) }}</span>
                                    </div>
                                    <div class="two pl-0 pr-3 py-2 align-self-stretch">
                                        <span class="yr">{{ date("Y", strtotime($post->created_at)) }}</span>
                                        <span class="mos">{{ date("F", strtotime($post->created_at)) }}</span>
                                    </div>
                                </div>
                                <h3 class="heading mb-3">
                                    <a href="\post/{{ $post->user->name }}/{{ str_replace(' ', '-', $post->post_title) }}-{{ $post->id }}">
                                        {{ $post->post_title }}
                                    </a>
                                </h3>
                                <p>
                                    {{ substr(str_replace("&nbsp;", "", strip_tags($post->post_description)), 0, 100) }} . . .
                                </p>
                                @foreach($post->tags as $tag)
                                    <a class="badge badge-info badge-pill"
                                       href="\post/tag/{{ $tag->name }}">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                                <p><a href="\post/{{ $post->user->name }}/{{ str_replace(' ', '-', $post->post_title) }}-{{ $post->id }}"
                                       class="btn-custom"><span class="ion-ios-arrow-round-forward mr-3"></span>Read more</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
