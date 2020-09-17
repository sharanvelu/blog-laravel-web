@extends('layouts.blog')

@section('doc_title', $post->post_title . ' - Sharan\'s Blog')

@section('content')
    @auth
        @if( Auth::user()->hasAnyRole(['SuperAdmin', 'Admin', 'Editor']) or $post->user_id == Auth::id() )
            <!-- Post Title, Edit and Delete Button -->
            <div class="justify-content-between row">
                <h2 class="col-11">{{ $post->post_title }}</h2>
                <form class="col-1">
                    @csrf
                    <a class="btn btn-outline-primary p-1 mt-1" href="\post/update/{{ $post->id }}">
                        <i class="fas fa-fw fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-outline-danger p-1 mt-1"
                            onclick="deletePost({{ $post }}, '{{ $post->user->name }}', this.form)">
                        <i class="fas fa-fw fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        @else
            <!-- Post Title -->
            <h2>{{ $post->post_title }}</h2>
        @endif
    @else
        <!-- Post Title -->
        <h2>{{ $post->post_title }}</h2>
    @endauth

    <!-- User and Created at -->
    <p class="text-secondary font-weight-light">
        <a href="#" class="text-decoration-none text-secondary">
            <i class="far fa-user mr-2"></i>{{ $user_name = $post->user->name }}</a>
        <span class="mx-3">|</span>
        <i class="far fa-calendar-alt mr-2"></i>{{ date("F j, Y ", strtotime($post->created_at)) }}
    </p>

    @if(!empty($post->image))
        <!-- Post Image -->
        <p><img src="{!! asset('storage/' . $post->image) !!}" alt="{{ $post->post_title }}-image"
                 class="img-fluid rounded">
        </p>
    @endif

    <!-- Tags -->
    @if( ($tags = $post->tags)->count() )
        <div class="mb-3">
            <div class="tag-cloud">
                <i class="fas fa-tags mr-2 text-secondary"></i>
                @foreach($tags as $tag)
                    <a href="\post/tag/{{ $tag->name }}" class="text-decoration-none">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Post Description -->
    <div id="desc">{!! $post->post_description !!}</div>

    <!-- Author's Profile -->
    <div class="d-flex p-4 mt-5 bg-light shadow">
        <div class="mr-5">
            <a href="\post/{{ $user_name }}">
                <img src="\res/images/person_default.jpg" alt="{{ $user_name }} - Profile Image"
                     class="img-fluid mb-4"/>
            </a>
        </div>
        <div>
            <h3><a href="\post/{{ $user_name }}" class="text-decoration-none text-dark">{{ $user_name }}</a>
            </h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus itaque, autem
                necessitatibus voluptate quod mollitia delectus aut, sunt placeat nam vero culpa
                sapiente consectetur similique, inventore eos fugit cupiditate numquam!</p>
        </div>
    </div>

    <!-- Comment Section Begins -->
    <div class="pt-5">
        <!-- Comments List Begins -->
        <ul class="list-unstyled" id="comment_list">
            <h3 class="mb-5">{{ ($comments = $post->comments)->count() }}
                @if( $comments->count() == 1 ) Comment @else Comments @endif
            </h3>
            @forelse($comments as $comment)
                <li class="mb-3 p-3 border rounded shadow-sm">
                    <div class="row d-flex m-0">
                        <h4 class="align-self-center">{{ $comment->user_name }}</h4>
                        @auth
                            @if( Auth::user()->hasAnyRole(['SuperAdmin', 'Admin', 'Editor']) or $post->user_id == Auth::id() )
                                <form class="ml-auto">
                                    @csrf
                                    <a class="btn btn-outline-primary p-1" href="#"
                                       data-toggle="modal" data-target="#edit_comment_modal"
                                       onclick="editComment({{ $comment }})">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger p-1"
                                            onclick="deleteComment({{ $comment }}, this.form)">
                                        <i class="fas fa-fw fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <div class="text-secondary my-3">
                        <i class="far fa-calendar-alt mr-2"></i>
                        {{ date("F j, Y ", strtotime($comment->created_at)) }}
                        <span class="mx-3">|</span>
                        <i class="far fa-clock mr-2"></i>{{ date("h:i A", strtotime($comment->created_at)) }}
                    </div>
                    <p>{{ $comment->comment }}</p>
                </li>
            @empty
                <li class="mb-3 p-3 border rounded">
                    <div class="text-center">
                        <h3>No Comments.</h3>
                        <p class="text-secondary">Be the first to comment.</p>
                    </div>
                </li>
            @endforelse
        </ul>
        <!-- Comment List Ends -->

        <!-- Comment Form Begins -->
        <div class="comment-form-wrap pt-5">
            <h3 class="mb-5">Leave a comment</h3>
            <form action="\comment/add" class="p-5 bg-light">
                @csrf
                <input type="hidden" value="{{ $post->id }}" name="post_id">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <span id="email_error" class="text-danger"></span>
                    <input type="email" class="form-control" id="comment_email" name="email" required
                           onkeyup="commentGetName(this.form)">
                </div>
                <div class="form-group">
                    <label for="name">Name *</label>
                    <span id="name_error" class="text-danger"></span>
                    <span id="name_info" class="text-info"></span>
                    <input type="text" class="form-control" id="comment_name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="website">Website</label>
                    <span id="website_error" class="text-danger"></span>
                    <input type="text" class="form-control" id="comment_website" name="website">
                </div>

                <div class="form-group">
                    <label for="message">Message *</label>
                    <span id="comment_error" class="text-danger"></span>
                    <textarea name="comment" id="comment_comment" cols="30" rows="10"
                              class="form-control" style="min-height: 100px; max-height: 350px"
                              required></textarea>
                </div>
                <div class="form-group">
                    <input type="button" class="btn py-3 px-4 btn-primary" value="Post Comment"
                           onclick="addComment(this.form)">
                </div>
            </form>
        </div>
        <!-- Comment form Ends -->
    </div>
    <!-- Comment Section Ends -->

    <!-- Edit Comment Modal-->
    <div class="modal fade" id="edit_comment_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        You are about to Edit this Comment.
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="comment_edit_form" action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label align-self-center text-md-right">User
                                Name<sup>*</sup>
                                :
                            </label>
                            <span id="comment_edit_name_error" class="text-danger"></span>
                            <input type="text" id="comment_edit_name" class="form-control" name="name"
                                   required
                                   value="">
                        </div>
                        <br>
                        <div class="form-group">
                            <label
                                class="col-form-label align-self-center text-md-right">Comment<sup>*</sup> :
                            </label>
                            <span id="comment_edit_comment_error" class="text-danger"></span>
                            <input type="text" id="comment_edit_comment" class="form-control" name="comment"
                                   required
                                   value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="comment_edit_submit" class="btn btn-primary"
                                onclick="updateComment(this.form)">Update
                        </button>
                        <button type="button" id="cancel_modal" class="btn btn-outline-secondary"
                                data-dismiss="modal">Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(window).scroll(function() {
            // calculate how much percentage the user has scrolled down the page
            let scroll_percent = $(window).scrollTop() / ($('#desc').height() + $('#desc').offset().top - 100) * 100;

            // bar on the top
            $('.scroll-status-bar').css('width', scroll_percent +"%"  );
        });
    </script>
@endsection
