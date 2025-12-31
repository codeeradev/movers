@extends('admin.layouts.dashboard')

@section('title', 'Edit Blog')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Edit Blog</h4>

    <form
        method="POST"
        action="{{ route('blogs.update', $blog->id) }}"
        enctype="multipart/form-data"
    >
        @method('PUT')

        @include('admin.blogs._form', [
            'blog' => $blog,
            'buttonText' => 'Update Blog'
        ])
    </form>
</div>
@endsection
