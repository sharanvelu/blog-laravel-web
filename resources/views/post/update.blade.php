@extends('layouts.blog')

@section('doc_title', 'Update Post - Sharan\'s Blog')

@section('content')
    <!-- Page Heading -->
    <div class="mb-4 overflow-auto">
        <h2>Update Post</h2>
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
    <form method="POST" action="\post/update/{{ $post->id }}" class="col-md-12 py-3 border rounded"
          enctype="multipart/form-data">
        @csrf

        <div class="form-group my-6">
            <label>Post Title<sup>*</sup> : </label>
            <input type="text" class="form-control" name="PostTitle" required placeholder="Enter Post Title"
                   value="{{ $post->post_title }}">
        </div>

        <div class="form-group my-6">
            <label>Post Description<sup>*</sup> : </label>
            <textarea name="PostDescription" id="post_description">{{ $post->post_description }}</textarea>
        </div>

        <div class="form-group">
            <label>Tags</label>
            <input class="form-control" name="tags" placeholder="Enter Tags" id="tags"
                   value="{{ $tags }}">
        </div>

        <div class="form-group">
            <label>Image</label>
            <input type="file" class="form-control" name="image"/>
            <input type="text" value="{{ $post->image }}" hidden name="img"/>
        </div>

        <div class="form-group col-md-6">
            <p class="mb-5">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->post_title }}-image" class="img-fluid">
            </p>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-outline-secondary ml-1" href="{{ __("\\post/home") }}">Cancel</a>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <!-- CDN SummerNote Editor -->
    <!-- summernote css/js cdn -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <!-- Jquery and css for tags input -->
    <script src="\res/tags/jquery.tagsinput.js"></script>
    <link href="\res/tags/jquery.tagsinput.css" rel="stylesheet" type="text/css" />

    <script>
        //Summer note WYSIWYG Editor Initiator
        $('#post_description').summernote({
            placeholder: 'Enter Post Description...',
            tabsize: 4,
            height: 150,
            minHeight: 150,
            maxHeight: null,
            focus: false
        });
        //tag input
        $('#tags').tagsInput();
    </script>
@endsection
