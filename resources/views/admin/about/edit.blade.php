@extends('admin.layouts.dashboard')

@section('title', 'Edit About Content')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Edit About Content</h3>
            <small class="text-muted">Update About Us information</small>
        </div>
        <a href="{{ route('about.index') }}" class="btn btn-secondary btn-sm">
            <i class="mdi mdi-arrow-left"></i> Back
        </a>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form
                method="POST"
                action="{{ route('about.update', $about->id) }}"
                enctype="multipart/form-data"
            >
                @method('PUT')

                {{-- 🔁 COMMON FORM --}}
                @include('admin.about._form')

            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
