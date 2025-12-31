@extends('admin.layouts.dashboard')

@section('title', 'Add About Content')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Add About Content</h4>

    <form
        method="POST"
        action="{{ route('about.store') }}"
        enctype="multipart/form-data"
    >
        @include('admin.about._form')
    </form>
</div>
@endsection
