@extends('admin.layouts.dashboard')

@section('title', 'Manage Process Images')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Manage Process Images</h3>
            <small class="text-muted">
                Update, preview or remove images used in frontend slider
            </small>
        </div>
        <a href="{{ route('car-process.index') }}" class="btn btn-secondary btn-sm">
            ← Back to List
        </a>
    </div>

    <!-- Gallery Grid -->
    <div class="row">
        @forelse($processes as $process)
            <div class="col-md-3">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body text-center">

                        <h6 class="mb-2">{{ $process->title }}</h6>

                        @if($process->image)
                            <img
                                src="{{ asset('uploads/car-process/'.$process->image) }}"
                                class="img-fluid rounded mb-2"
                                style="height:140px;object-fit:cover;cursor:pointer;"
                                onclick="viewImage('{{ asset('uploads/car-process/'.$process->image) }}')"
                            >
                        @else
                            <div class="text-muted mb-3" style="height:140px;display:flex;align-items:center;justify-content:center;">
                                No Image
                            </div>
                        @endif

                        <!-- Update Image -->
                        <form
                            method="POST"
                            action="{{ route('car-process.update', $process->id) }}"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            @method('PUT')

                            <input
                                type="file"
                                name="image"
                                class="form-control form-control-sm mb-2"
                                accept="image/*"
                            >

                            <button class="btn btn-sm btn-primary w-100 mb-1">
                                Update Image
                            </button>
                        </form>

                        <!-- Remove Image -->
                        @if($process->image)
                            <button
                                class="btn btn-sm btn-danger w-100 remove-image"
                                data-id="{{ $process->id }}">
                                Remove Image
                            </button>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No process steps found.
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
/* 🔍 View Image */
function viewImage(src) {
    Swal.fire({
        imageUrl: src,
        imageAlt: 'Process Image',
        showConfirmButton: false,
        width: 600
    });
}

/* 🗑️ Remove Image */
$(document).on('click', '.remove-image', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: 'Remove image?',
        text: 'This will remove image only, not the process step.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, remove'
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: '/car-process/' + id + '/remove-image',
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Removed',
                        text: res.message,
                        timer: 1200,
                        showConfirmButton: false
                    }).then(() => location.reload());
                },
                error: function () {
                    Swal.fire(
                        'Error',
                        'Something went wrong',
                        'error'
                    );
                }
            });
        }
    });
});
</script>
@endpush
