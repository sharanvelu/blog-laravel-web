@extends('layouts.blog')

@section('head_title', 'Sharan\'s Blog')

@section('content')
    <div class="col-lg-8">
        <!-- Blog Post -->
        @foreach($posts as $post)
            <div class="blog-entry justify-content-end ftco-animate shadow-sm rounded">
                <a href="\post/{{ $post_user_name = $post->user->name }}/{{ str_replace(' ', '-', $post->post_title) }}-{{ $post->id }}"
                   class="block-20" style="background-image: url('{{ asset('storage/'.$post->image) }}');">
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
                        <a href="\post/{{ $post_user_name }}/{{ str_replace(' ', '-', $post->post_title) }}-{{ $post->id }}">
                            {{ $post->post_title }}
                        </a>
                    </h3>
                    <p>{{ substr(str_replace("&nbsp;", "", strip_tags($post->post_description)), 0, 100) }}. . .</p>
                    <p>
                        <a href="\post/{{ $post_user_name }}/{{ str_replace(' ', '-', $post->post_title) }}-{{ $post->id }}"
                           class="btn-custom"><span class="ion-ios-arrow-round-forward mr-3"></span>Read
                            more</a>
                    </p>
                </div>
            </div>
        @endforeach
    </div>

@endsection
