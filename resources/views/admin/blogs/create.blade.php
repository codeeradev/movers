@extends('admin.layouts.dashboard')

@section('title', 'Add Blog')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Add Blog</h4>

    <form
        method="POST"
        action="{{ route('blogs.store') }}"
        enctype="multipart/form-data"
    >
        @include('admin.blogs._form', [
            'blog' => null,
            'buttonText' => 'Create Blog'
        ])
    </form>
</div>
@endsection
