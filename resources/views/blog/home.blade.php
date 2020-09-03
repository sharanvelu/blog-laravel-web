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
        <a class="text-decoration-none"
           href="\post/{{ $post_user_name = $users->find($post->user_id)->name }}/{{ str_replace('?','-', str_replace(' ', '-', $post->post_title)) }}-{{ $post->id }}">
            <div class="post">
                <div style="background-image: url('{!! asset('storage/' . $post->image) !!}');"
                     class="col-12 post-img"></div>
                <div class="time d-flex align-items-center">
                    <div class="one py-2 pl-3 pr-1 align-self-stretch">
                        <span class="day">{{ date("j", strtotime($post->created_at)) }}</span>
                    </div>
                    <div class="two pl-0 pr-3 py-2 align-self-stretch">
                        <span class="year">{{ date("Y", strtotime($post->created_at)) }}</span>
                        <span class="month">{{ date("F", strtotime($post->created_at)) }}</span>
                    </div>
                </div>
                <div class="p-4 text-justify">
                    <h4 class="font-weight-bold text-dark">{{ $post->post_title }}</h4>
                    <p class="text-secondary">
                        {{ substr($str = html_entity_decode(strip_tags($post->post_description)), 0, 150) }}
                        @if(strlen($str) > 150) . . .@endif
                    </p>
                    <div class="text-secondary row m-0 justify-content-between">
                        <div><i class="far fa-user mr-2"></i>{{ $post_user_name }}</div>
                        <div><i class="fas fa-arrow-right mr-2 post-read-more"></i>Read more</div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach

    {{ $posts->links() }}

@endsection
