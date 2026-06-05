@extends('admin.layouts.dashboard')

@section('title', 'Edit FAQ')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Edit FAQ</h3>
            <small class="text-muted">Update FAQ content shown on the frontend</small>
        </div>
        <a href="{{ route('faqs.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('faqs.update', $faq->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.faqs._form')
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update FAQ</button>
                    <a href="{{ route('faqs.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
