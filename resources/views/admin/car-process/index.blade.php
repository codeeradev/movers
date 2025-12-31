@extends('admin.layouts.dashboard')

@section('title', 'Car Shifting Process')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Car Shifting Process</h3>
            <small class="text-muted">Manage steps shown on frontend slider</small>
        </div>
        <a href="{{ route('car-process.create') }}" class="btn btn-primary btn-sm">
            <i class="mdi mdi-plus"></i> Add Step
        </a>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table id="processTable" class="table align-middle table-striped table-bordered w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Title</th>
                        <th width="10%">Image</th>
                        <th width="10%">Status</th>
                        <th width="8%">Order</th>
                        <th width="12%">Action</th>
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
/* 🔥 Modern tweaks */
.card {
    border-radius: 12px;
}
.table td, .table th {
    vertical-align: middle !important;
}
.dataTables_filter input {
    border-radius: 20px;
    padding: 6px 12px;
}
.dataTables_length select {
    border-radius: 8px;
}
.badge {
    padding: 6px 10px;
    font-size: 12px;
}
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
$(document).ready(function () {

    $('#processTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        searching: true,
        paging: true,
        ordering: false,
        pageLength: 10,

        ajax: {
            url: "{{ route('car-process.ajax') }}",
            type: "GET"
        },

        columns: [
            { data: 'sr_no' },
            { data: 'title' },
            { data: 'image', orderable: false, searchable: false },
            { data: 'status' },
            { data: 'sort_order' },
            { data: 'action', orderable: false, searchable: false }
        ],

        language: {
            search: "",
            searchPlaceholder: "Search steps...",
            lengthMenu: "Show _MENU_ entries",
            processing: "Loading data..."
        }
    });

});
</script>
<script>
$(document).on('click', '.delete-btn', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This step will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '/car-process/' + id,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: res.message || 'Step deleted successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    $('#processTable').DataTable().ajax.reload(null, false);
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'Something went wrong. Please try again.',
                        'error'
                    );
                }
            });

        }
    });
});
</script>

@endpush
