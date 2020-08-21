@extends('layouts.blog')

@section('doc_title', 'Search Results for "' . $search_key . '" - Sharan\'s Blog')

@section('content')
    <h1>Search Results for "{{ $search_key }}"</h1>
    <!-- Search results for Tags -->
    <h2 class="mt-4 mb-4">Tags</h2>
    <p class="text-gray-800">
        @if($posts->count())
            @if($posts->count() == 1) 1 Tag @else {{ $posts->count() }} Tags @endif
        @else No Tag @endif have been found
    </p>
    <div class="row">
        @foreach($tags as $tag)
            <div onclick="window.location.href = '\\{{ $tag->url }}'" class="search-result-tag">
                {{ $tag->title }}</div>
        @endforeach
    </div>


    <hr class="mt-4 mb-4">


    <!-- Search Results for Post -->
    <h2 class="mt-4 mb-4">Posts</h2>
    <p class="text-gray-800">
        @if($posts->count())
            @if($posts->count() == 1) 1 Post @else {{ $posts->count() }} Posts @endif
        @else No Post @endif have been found
    </p>
    @foreach($posts as $post)
        <div class="blog-entry justify-content-end ftco-animate rounded">
            <a href="{{ $post->url }}"
               class="block-20" style="background-image: url('{{ asset('storage/' . $post->searchable->image) }}');">
            </a>
            <div class="text p-4 float-right d-block">
                <div class="topper d-flex align-items-center">
                    <div class="one py-2 pl-3 pr-1 align-self-stretch">
                        <span class="day">{{ date("j", strtotime($post->searchable->created_at)) }}</span>
                    </div>
                    <div class="two pl-0 pr-3 py-2 align-self-stretch">
                        <span class="yr">{{ date("Y", strtotime($post->searchable->created_at)) }}</span>
                        <span class="mos">{{ date("F", strtotime($post->searchable->created_at)) }}</span>
                    </div>
                </div>
                <h3 class="heading mb-3">
                    <a href="{{ $post->url }}">{{ $post->title }}</a>
                </h3>
                <p>{{ substr(html_entity_decode(strip_tags($post->searchable->post_description)), 0, 200) }}. . .</p>
                <p>
                    <a href="{{ $post->url }}"
                       class="btn-custom"><span class="ion-ios-arrow-round-forward mr-3"></span>Read more</a>
                </p>
            </div>
        </div>
    @endforeach

@endsection
