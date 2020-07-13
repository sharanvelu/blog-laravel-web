@extends('layouts.app')

@section('head')
    <!-- CDN SummerNote Editor -->
    <!-- include bootstrap libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <!-- Jquery and css for tags -->
    <script src="\tags_jquery/jquery.tagsinput.js"></script>
    <link rel="stylesheet" type="text/css" href="\tags_jquery/jquery.tagsinput.css" />

@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Post</h1>
    </div>

    @if ($errors->any())
        <div class="d-flex justify-content-center">
            <div class="alert alert-danger col-8">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Post Create Form -->
    <form method="POST" action="\post/create" class="content col-11 mx-auto my-3" enctype="multipart/form-data">
        @csrf

        <div class="form-group my-6">
            <label>Post Title<sup>*</sup> : </label>
            <input type="text" class="form-control" name="PostTitle" required placeholder="Enter Post Title">
        </div>

        <div class="form-group my-6">
            <label>Post Description<sup>*</sup> : </label>
            <textarea name="PostDescription" id="post_description"></textarea>
        </div>

        <div class="form-group">
            <label>Image</label>
            <input type="file" class="form-control" name="image">
        </div>

        <div class="form-group">
            <label>Tags</label>
            <input class="form-control" name="tags" placeholder="Enter Tags" id="tags">
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Create') }}
                </button>
                <button type="reset" class="btn btn-outline-secondary ml-1">
                    {{ __('Reset') }}
                </button>
                <a class="btn btn-outline-secondary ml-1" href="{{ __("\\showUserPost") }}">Cancel</a>
            </div>
        </div>
    </form>
@endsection
