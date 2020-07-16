@extends('layouts.blog')

@section('head_title', $post->post_title . ' - Sharan\'s Blog')

@section('content')

    <section class="hero-wrap hero-wrap-2 js-fullheight"
             style="max-height: 250px;"
             data-stellar-background-ratio="0.4">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-degree-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 ftco-animate">
                    <div class="justify-content-between row">
                        <h2 class="mb-3 ml-3">{{ $post->post_title }}</h2>
                        @auth
                            @if( Auth::user()->hasAnyRole(['SuperAdmin', 'Admin', 'Editor']) or $post->user_id == Auth::id() )
                                <form class="mr-3 pr-3">
                                    @csrf
                                    <a class="btn btn-outline-primary p-1" href="\post/update/{{ $post->id }}">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger p-1"
                                            onclick="deletePost({{ $post }}, '{{ $post->user->name }}', this.form)">
                                        <i class="fas fa-fw fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <p class="text-gray-100 font-weight-light">{{ date("F j, Y ", strtotime($post->created_at)) }}</p>
                    <p class="mb-5">
                        <img src="\{{ $post->image }}" alt="{{ $post->post_title }}-image" class="img-fluid">
                    </p>
                    <div>
                        <?php echo $post->post_description ?>
                    </div>
                    <!-- Tags -->
                    <?php $tags = $post->tags ?>
                    @if(!empty($tags))
                        <div class="tag-widget post-tag-container mb-5 mt-5">
                            <div class="tagcloud">
                                Tags :&nbsp;
                                @foreach($tags as $tag)
                                    <a href="\post/tag/{{ $tag->name }}" class="tag-cloud-link">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        </div>
                @endif

                <!-- Author's Profile -->
                    <div class="about-author d-flex p-4 bg-light">
                        <div class="bio mr-5">
                            <img src="\blog/images/person_default.jpg" alt="Image placeholder" class="img-fluid mb-4">
                        </div>
                        <div class="desc">
                            <h3>{{ $post->user->name }}</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus itaque, autem
                                necessitatibus voluptate quod mollitia delectus aut, sunt placeat nam vero culpa
                                sapiente consectetur similique, inventore eos fugit cupiditate numquam!</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Comments -->
                    <div class="pt-5">
                        <?php $comments = $post->comments ?>
                        <h3 class="mb-5">{{ $comments->count() }}
                            @if($comments->count() == 1)
                                Comment
                            @else
                                Comments
                            @endif
                        </h3>
                        <ul class="comment-list" id="comment_list">
                            @forelse($comments as $comment)
                                <li class="comment">
                                    <div class="vcard bio">
                                        <img src="\blog/images/person_default.jpg" alt="Image placeholder">
                                    </div>
                                    <div class="comment-body">
                                        <div class="row justify-content-between">
                                            <div class="row ml-3">
                                                <h3>{{ $comment->user_name }}</h3>&nbsp;&nbsp;
                                                @if( in_array( $comment->user_email, array_column( App\User::get('email')->all(), 'email')))
                                                    @if(App\User::where('email', $comment->user_email)->first()->roles->first())
                                                        <span>
                                                            <sup class="text-capitalize text-primary">
                                                                {{ App\User::where('email', $comment->user_email)->first()->roles->first()->name }}
                                                            </sup>
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>
                                            @auth
                                                @if( Auth::user()->hasAnyRole(['SuperAdmin', 'Admin', 'Editor']) or $post->user_id == Auth::id() )
                                                    <form class="mr-3 pr-3">
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
                                        <div class="meta mb-3">
                                            {{ date("F j, Y ", strtotime($comment->created_at)) }} AT
                                            {{ date("h:i A", strtotime($comment->created_at)) }}
                                        </div>
                                        <p>{{ $comment->comment }}</p>
                                        {{--<p><a href="#" class="reply">Reply</a></p>--}}
                                    </div>
                                </li>
                            @empty
                                <li class="comment">
                                    <div class="vcard bio">
                                        <img src="\blog/images/person_default.jpg" alt="Image placeholder">
                                    </div>
                                    <div class="comment-body">
                                        <h3>No Comment</h3>
                                        <p>Be the first to comment</p>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                        <!-- END comment-list -->

                        <div class="comment-form-wrap pt-5">
                            <h3 class="mb-5">Leave a comment</h3>
                            <form action="\comment/add" class="p-5 bg-light">
                                @csrf
                                <input type="hidden" value="{{ $post->id }}" name="post_id">
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <span id="name_error" class="text-danger"></span>
                                    <input type="text" class="form-control" id="comment_name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <span id="email_error" class="text-danger"></span>
                                    <input type="email" class="form-control" id="comment_email" name="email" required>
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
                                              class="form-control"
                                              required></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="button" class="btn py-3 px-4 btn-primary" value="Post Comment"
                                           onclick="addComment(this.form)">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Side Bar -->
                <div class="col-lg-4 sidebar pl-lg-5 ftco-animate">
                    <div class="sidebar-box">
                        <form action="#" class="search-form">
                            <div class="form-group">
                                <span class="icon icon-search"></span>
                                <input type="text" class="form-control" placeholder="Type a keyword and hit enter">
                            </div>
                        </form>
                    </div>
                    <div class="sidebar-box ftco-animate">
                        <div class="categories">
                            <h3>Categories</h3>
                            <li><a href="#">Illustration <span class="ion-ios-arrow-forward"></span></a></li>
                            <li><a href="#">Branding <span class="ion-ios-arrow-forward"></span></a></li>
                            <li><a href="#">Application <span class="ion-ios-arrow-forward"></span></a></li>
                            <li><a href="#">Design <span class="ion-ios-arrow-forward"></span></a></li>
                            <li><a href="#">Marketing <span class="ion-ios-arrow-forward"></span></a></li>
                        </div>
                    </div>

                    <div class="sidebar-box ftco-animate">
                        <h3>Recent Blog</h3>
                        @foreach(App\Post::latest()->take(3)->get() as $latest_post)
                            <div class="block-21 mb-4 d-flex">
                                <a class="img mr-4 rounded"
                                   href="\post/{{ $latest_post->user->name }}/{{ str_replace(' ', '-', $latest_post->post_title) }}-{{ $latest_post->id }}"
                                   style="background-image: url('\\{{ $latest_post->image }}');"></a>
                                <div class="text">
                                    <h3 class="heading"><a
                                            href="\post/{{ $latest_post->user->name }}/{{ str_replace(' ', '-', $latest_post->post_title) }}-{{ $latest_post->id }}">
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

                    <div class="sidebar-box ftco-animate">
                        <h3>Tag Cloud</h3>
                        <div class="tagcloud">
                            @foreach(App\Tag::latest()->take(50)->get() as $tag)
                                <a href="\post/tag/{{ $tag->name }}" class="tag-cloud-link">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Edit Comment Modal-->
    <div class="modal fade" id="edit_comment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                            <label class="col-form-label align-self-center text-md-right">User Name<sup>*</sup> :
                            </label>
                            <span id="comment_edit_name_error" class="text-danger"></span>
                            <input type="text" id="comment_edit_name" class="form-control" name="name" required
                                   value="">
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-form-label align-self-center text-md-right">Comment<sup>*</sup> : </label>
                            <span id="comment_edit_comment_error" class="text-danger"></span>
                            <input type="text" id="comment_edit_comment" class="form-control" name="comment" required
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
