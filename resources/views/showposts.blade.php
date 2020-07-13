@extends('layouts.post')

@section('sidebar')
    <!-- Sidebar Beginning -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="ml-4 mt-4 d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
            <div class="sidebar-brand-text mx-3">
                @auth
                    {{ Auth::user()->name }}
                @else
                    LARAVEL
                @endauth
            </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

    @auth
        <!-- Nav Item - Dashboard -->
            <li class="nav-item" id="dashBoard_active">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    {{ __('Dashboard') }}
                </a>
            </li>
    @else
        <!-- Nav Item - Login -->
            <li class="nav-item" id="login_active">
                <a class="nav-link" href="{{ route('login') }}">
                    <i class="fas fa-fw fa-sign-in-alt"></i>
                    {{ __('Login') }}
                </a>
            </li>

            <!-- Nav Item - Register -->
            <li class="nav-item" id="register_active">
                <a class="nav-link" href="{{ route('register') }}">
                    <i class="fas fa-fw fa-magnet"></i>
                    {{ __('Register') }}
                </a>
            </li>
    @endauth

    <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            POST
        </div>

    @auth
        <!-- Nav Item - Create Post -->
            <li class="nav-item" id="create_active">
                <a class="nav-link" href="{{ route('create') }}">
                    <i class="fas fa-fw fa-crown"></i>
                    <span>Create Post</span></a>
            </li>

            <!-- Nav Item - Show My Post -->
            <li class="nav-item" id="my_post_sidebar">
                <a class="nav-link" href="\post/list-post/{{ Auth::id() }}">
                    <i class="fas fa-fw fa-desktop"></i>
                    <span>Show My Post</span></a>
            </li>
    @endauth

    <!-- Nav Item - Show All Post -->
        <li class="nav-item" id="all_post_sidebar">
            <a class="nav-link" href="\post/list-post">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Show all Post</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Heading -->
        <div class="sidebar-heading">
            Role
        </div>

        <!-- Roles Sidebar -->
        <li class="nav-item" id="roles_sidebar">
            <a class="nav-link" href="\role/list">
                <i class="fas fa-fw fa-paint-roller"></i>
                <span>Roles</span></a>
        </li>

        <!-- Assign Role Sidebar -->
        <li class="nav-item" id="assign_role_sidebar">
            <a class="nav-link" href="\role/assign-role">
                <i class="fas fa-fw fa-paint-roller"></i>
                <span>Assign Role</span></a>
        </li>

    </ul>
    <!-- End of Sidebar -->
@endsection

@section('contents')
    <?php
    ?>
    <div class="col-lg-8">
        <!-- Post Title -->
        <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="mt-4" id="page_content_title">{{ $postData ?? ''->post_title }}</h1>
            <div>
            @if( $postData ?? ''->user_id == Auth::id() )
                <!-- Edit button to initiate Edit Modal -->
                    <a class="btn-circle btn-primary mr-1" href="#"
                       data-toggle="modal" data-target="#crudModal"
                       onclick="edit_function({{ $postData ?? '' }})">
                        <i class="fas fa-fw fa-edit"></i>
                    </a>
                    <a class="btn-circle btn-danger text-white mr-1" href="#"
                       data-toggle="modal" data-target="#crudModal"
                       onclick="delete_function({{ $postData ?? '' }})">
                        <i class="fas fa-fw fa-trash-alt"></i>
                    </a>
                @else
                    <button class="btn-circle btn-outline-primary mr-1" disabled>
                        <i class="fas fa-fw fa-edit"></i>
                    </button>
                    <button class="btn-circle btn-outline-danger mr-1" disabled>
                        <i class="fas fa-fw fa-trash-alt"></i>
                    </button>
                @endif
            </div>
        </div>

        <!-- Post Author -->
        <p class="lead">
            by <a href="\post/list-post/{{ $postData ?? ''->user_id }}">{{ $users[$postData ?? ''->user_id - 1]->name }}</a>
        </p>

        <hr>
        <!-- Date/Time -->
        Posted on {{ date("F j, Y - h:i A", $postData ?? ''->created_at->getTimestamp()) }}
        <hr>

        <!-- Preview Image -->
        @if($postData ?? ''->image)
            <img class="img-fluid rounded" id="zpage_content_image" src="\{{ $postData ?? ''->image }}" alt="">
            <hr>
        @endif

    <!-- Post Description -->
        <div id="page_content_desc">
            <?php echo $postData ?? ''->post_description ?>
        </div>
        <hr>

        <!-- Tags -->
        @if(!empty($tag_ids))
            Tags :
            @foreach($tag_ids as $tag_id)
                <a class="badge badge-primary" href="\post/list-post/tag/{{ $tag_id->tag_id }}">
                    {{ $tags[$tag_id->tag_id - 1]->name }}
                </a>
            @endforeach
            <hr>
    @endif

    <!-- Comments Section -->
        <div class="card my-4 pb-3">
            <h5 class="card-header">Leave a Comment:</h5>
            <div class="card-body">
            @auth
                <!-- Comment form -->
                    <form method="post" action="\comment/add">
                        @csrf
                        <input type="hidden" value="{{ $postData ?? ''->id }}" name="post_id">
                        <input type="hidden" value="{{ Auth::id() }}" name="user_id">
                        <div class="form-group">
                            <textarea class="form-control" id="comment" rows="3" name="comment" required
                                      placeholder="Comments please..."></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" id="comment_submit"
                                onclick="ajaxCall(this.form)">Submit
                        </button>
                    </form>
                @else
                    <div id="comment_list">
                        <div class="mx-3 mt-3 py-3 px-3 bg-gray-100 rounded">
                            <div class="text-center">
                                Please Login or Register to comment
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            <hr class="col-11 mx-auto my-0">
            <!-- Comments -->
            <div id="comment_list">
                @forelse($comments as $comment)
                    <form>
                        @csrf
                        <div class="mx-3 mt-3 py-3 px-3 bg-gray-100 rounded">
                            <!-- Comment Header -->
                            <div class="d-sm-flex justify-content-between">
                                <div>
                                    <a><img src="\images/download.png" class="p-0" width="40px"></a>
                                    <a class="ml-2 card-link" href="\post/list-post/{{ $comment->user_id }}">
                                        {{ $users[$comment->user_id]->name }}
                                    </a>
                                </div>
                                <div class="my-auto">
                                    <a class="my-auto">
                                        {{ getTimeAgo(strtotime($comment->created_at)) }}
                                    </a>

                                    <!-- Edit Button -->
                                    @if($comment->user_id == Auth::id())
                                        <button type="button" class="btn-circle btn-sm btn-primary"
                                                id="editButton" onclick="edit({{ $comment->id }})">
                                            <i class="fas fa-fw fa-edit"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn-circle btn-sm btn-outline-primary"
                                                disabled>
                                            <i class="fas fa-fw fa-edit"></i>
                                        </button>
                                    @endif

                                <!-- Delete Button -->
                                    @if($comment->user_id == Auth::id() or $postData ?? ''->user_id == Auth::id())
                                        <button type="button" class="btn-circle btn-sm btn-danger"
                                                onclick="del({{ $comment->id }})">
                                            <i class="fas fa-fw fa-trash-alt"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn-circle btn-sm btn-outline-danger" disabled>
                                            <i class="fas fa-fw fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <!-- Comment Body -->
                            <div class="my-3">
                                <div id="updateSection{{$comment->id}}" style="display: none">
                                    <textarea class="text-justify form-control" name="comment"
                                    >{{ $comment->comment }}</textarea>
                                    <button type="button" class="btn-outline-primary btn mt-3"
                                            id="submitButton{{ $comment->id }}"
                                            onclick="updateDeleteComment(this.form,  'update/', {{ $comment->id }})">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary mt-3 ml-3"
                                            onclick="cancel({{ $comment->id }})">
                                        Cancel
                                    </button>
                                </div>
                                <p id="comment{{$comment->id}}">{{ $comment->comment }}</p>
                                <div id="deleteSection{{ $comment->id }}" style="display: none">
                                    <p id="comment{{$comment->id}}" class="text-danger">{{ $comment->comment }}</p>
                                    <button type="button" class="btn-outline-danger btn mt-3"
                                            id="deleteButton{{ $comment->id }}"
                                            onclick="updateDeleteComment(this.form, 'delete/', {{ $comment->id }})">
                                        Delete
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary mt-3 ml-3"
                                            onclick="cancel({{ $comment->id }})">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @empty
                    <div class="mx-3 mt-3 py-3 px-3 bg-gray-100 rounded">
                        <div>
                            <p>No Comment.</p>
                            <p>Be the first to reply.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <?php
    function getTimeAgo($time)
    {
        $time_difference = time() - $time;
        if ($time_difference < 30) {
            return 'Just now';
        }
        $condition = array(12 * 30 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );
        foreach ($condition as $secs => $str) {
            $d = $time_difference / $secs;
            if ($d >= 1) {
                $t = round($d);
                return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
            }
        }
    }
    ?>
@endsection

@section('script')
    <script>
        function ajaxCall(form) {
            $('#comment_submit').attr('disabled', true);
            $.ajax({
                url: form.action,
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (success) {
                    $("#comment_list").load(location.href + " #comment_list");
                    $('#comment_submit').attr('disabled', false);
                    $('#comment').val("");
                },
                error: function (error) {
                    console.log(error);
                    alert(error.responseJSON.errors.comment);
                    $('#comment_submit').attr('disabled', false);
                }
            });
        }

        function updateDeleteComment(form, action, id) {
            $('#submitButton' + id).attr('disabled', true);
            $('#deleteButton' + id).attr('disabled', true);
            $.ajax({
                url: "\\comment/" + action + id,
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (success) {
                    $("#comment_list").load(location.href + " #comment_list");
                },
                error: function (error) {
                    alert(error.responseJSON.errors.comment);
                    $('#submitButton' + id).attr('disabled', false);
                    $('#deleteButton' + id).attr('disabled', false);
                }
            });
        }

        function edit(id) {
            $('#updateSection' + id).show();
            $('#comment' + id).hide();
            $('#deleteSection' + id).hide();
        }

        function del(id) {
            $('#updateSection' + id).hide();
            $('#comment' + id).hide();
            $('#deleteSection' + id).show();
        }

        function cancel(id) {
            $('#updateSection' + id).hide();
            $('#comment' + id).show();
            $('#deleteSection' + id).hide();
        }

    </script>

@endsection
