@extends('admin.layouts.dashboard')

@section('title', 'Testimonials')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Testimonials</h3>
            <small class="text-muted">Manage client feedback shown on website</small>
        </div>
        <a href="{{ route('testimonials.create') }}" class="btn btn-primary btn-sm">
            <i class="mdi mdi-plus"></i> Add Testimonial
        </a>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table id="testimonialTable" class="table table-hover align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Name</th>
                        <th width="15%">Image</th>
                        <th>Message</th>
                        <th width="10%">Status</th>
                        <th width="8%">Order</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>

</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<style>
.card { border-radius: 12px; }
.table td, .table th { vertical-align: middle !important; }
.dataTables_filter input {
    border-radius: 20px;
    padding: 6px 12px;
}
.badge { font-size: 12px; padding: 6px 10px; }
.action-btns .btn {
    padding: 4px 10px;
    font-size: 12px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {

    let table = $('#testimonialTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ordering: false,
        pageLength: 10,

        ajax: {
            url: "{{ route('testimonials.ajax') }}",
            type: "GET"
        },

        columns: [
            { data: 'sr_no' },
            { data: 'name' },
            { data: 'image', orderable:false, searchable:false },
            { data: 'message' },
            { data: 'status' },
            { data: 'sort_order' },
            { data: 'action', orderable:false, searchable:false }
        ],

        language: {
            search: "",
            searchPlaceholder: "Search testimonials...",
            processing: "Loading testimonials..."
        }
    });

    /* 🗑️ Delete */
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete testimonial?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/testimonials/' + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            timer: 1200,
                            showConfirmButton: false
                        });
                        table.ajax.reload(null, false);
                    }
                });
            }
        });
    });

});
</script>
@endpush
