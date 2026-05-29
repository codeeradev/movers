@extends('admin.layouts.dashboard')

@section('title', 'Edit Service')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-0">Edit Service</h3>
        <small class="text-muted">Update the service card content</small>
    </div>

    <form action="{{ route('admin-services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.services._form', ['buttonText' => 'Update Service'])
    </form>
</div>
@endsection
