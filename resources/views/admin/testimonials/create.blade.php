@extends('admin.layouts.dashboard')

@section('title', 'Add Testimonial')

@section('content')
<div class="container-fluid">
    <h4>Add Testimonial</h4>

    <form 
        method="POST" 
        action="{{ route('testimonials.store') }}" 
        enctype="multipart/form-data"
    >
        @csrf
        @include('admin.testimonials._form', ['testimonial' => null])
    </form>
</div>
@endsection
