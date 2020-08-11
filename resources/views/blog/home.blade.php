@extends('layouts.blog')

@section('doc_title', 'Sharan\'s Blog')

@section('content')
    @if( $title ?? '' )
        <h1 class="mb-4">{{ $title }}</h1>

        @if( empty($posts->count()) )
            No posts have been found
        @endif
    @endif

    <!-- Blog Post -->
    @foreach($posts as $post)
        <div class="blog-entry justify-content-end ftco-animate rounded">
            <a class="block-20"
               style="background-image: url('https://t2r6u7f9.rocketcdn.me/figz/wp-content/seloads/2016/03/google-code-seo-algorithm6-ss-1920-800x450.jpg');"
               href="\post/{{ $post_user_name = $users->find($post->user_id)->name }}/{{ str_replace('?','-', str_replace(' ', '-', $post->post_title)) }}-{{ $post->id }}">
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
                <p>{{ substr(html_entity_decode(strip_tags($post->post_description)), 0, 200) }}. . .</p>
                <p>
                    <a href="\post/{{ $post_user_name }}/{{ str_replace(' ', '-', $post->post_title) }}-{{ $post->id }}"
                       class="btn-custom"><span class="ion-ios-arrow-round-forward mr-3"></span>Read more</a>
                </p>
            </div>
        </div>
    @endforeach

    {{ $posts->links() }}

@endsection
