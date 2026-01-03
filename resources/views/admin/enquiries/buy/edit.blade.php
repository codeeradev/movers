@extends('admin.layouts.dashboard')
@section('title', 'Edit Buy Inquiry')

@section('content')

<div class="card rounded-4 shadow-lg">
    <div class="card-header bg-primary text-white rounded-top-4">
        <h4 class="mb-0 fw-bold">Edit Inquiry</h4>
    </div>

    <form action="{{ route('inquiries.update', $enquiry->id) }}" method="POST" class="p-4">
        @csrf
        @method('PUT')

        @include('admin.enquiries.buy.form')

        <button class="btn btn-success mt-3">Update Inquiry</button>
    </form>
</div>

@endsection
