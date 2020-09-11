@extends('layouts.blog')

@section('doc_title', 'Search Results for "' . $search_key . '" - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4 overflow-auto">
        <h2>Search Results for "{{ $search_key }}"</h2>
    </div>
    <!-- Search results for Tags -->
    <h2 class="mt-4 mb-4">Tags</h2>
    <p class="text-secondary">
        @if($tags->count())
            @if($tags->count() == 1) 1 Tag @else {{ $tags->count() }} Tags @endif
        @else No Tag @endif have been found
    </p>
    <div class="tag-cloud">
        @foreach($tags as $tag)
            <a href="\post/tag/{{ $tag->title }}" class="text-decoration-none">
                {{ $tag->title }}</a>
        @endforeach
    </div>

    <hr class="mt-4 mb-4">

    <!-- Search Results for Post -->
    <h2 class="mt-4 mb-4">Posts</h2>
    <p class="text-secondary">
        @if($posts->count())
            @if($posts->count() == 1) 1 Post @else {{ $posts->count() }} Posts @endif
        @else No Post @endif have been found
    </p>
    @foreach($posts as $post)
        <a class="text-decoration-none"
           href="\post/{{ $post_user_name = $users->find($post->searchable->user_id)->name }}/{{ str_replace('?','-', str_replace(' ', '-', $post->title)) }}-{{ $post->searchable->id }}">
            <div class="post">
                <div style="background-image: url('{!! asset('storage/' . $post->searchable->image) !!}');"
                     class="col-12 post-img"></div>
                <div class="time d-flex align-items-center">
                    <div class="one py-2 pl-3 pr-1 align-self-stretch">
                        <span class="day">{{ date("j", strtotime($post->searchable->created_at)) }}</span>
                    </div>
                    <div class="two pl-0 pr-3 py-2 align-self-stretch">
                        <span class="year">{{ date("Y", strtotime($post->searchable->created_at)) }}</span>
                        <span class="month">{{ date("F", strtotime($post->searchable->created_at)) }}</span>
                    </div>
                </div>
                <div class="p-4 text-justify">
                    <h4 class="font-weight-bold text-dark">{{ $post->title }}</h4>
                    <p class="text-secondary">
                        {{ substr($str = html_entity_decode(strip_tags($post->searchable->post_description)), 0, 150) }}
                        @if(strlen($str) > 150) . . .@endif
                    </p>
                    <div class="text-secondary row m-0 justify-content-between">
                        <div><i class="far fa-user mr-2"></i>{{ $post_user_name }}</div>
                        <div><i class="fas fa-arrow-right mr-2"></i>Read more</div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach

@endsection
