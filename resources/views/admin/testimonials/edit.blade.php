@extends('admin.layouts.dashboard')

@section('title', 'Edit Testimonial')

@section('content')
<div class="container-fluid">
    <h4>Edit Testimonial</h4>

    <form 
        method="POST" 
        action="{{ route('testimonials.update', $testimonial->id) }}" 
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        @include('admin.testimonials._form', ['testimonial' => $testimonial])
    </form>
</div>
@endsection
