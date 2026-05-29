@extends('admin.layouts.dashboard')

@section('title', 'Add Service')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-0">Add Service</h3>
        <small class="text-muted">Create a new homepage service card</small>
    </div>

    <form action="{{ route('admin-services.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.services._form', ['buttonText' => 'Save Service'])
    </form>
</div>
@endsection
