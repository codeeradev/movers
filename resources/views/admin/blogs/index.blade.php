@extends('admin.layouts.dashboard')

@section('title', 'Blog Management')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Blog Management</h3>
            <small class="text-muted">Manage blogs shown on website</small>
        </div>
        <a href="{{ route('blogs.create') }}" class="btn btn-primary btn-sm">
            <i class="mdi mdi-plus"></i> Add Blog
        </a>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="blogTable" class="table table-hover align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Title</th>
                        <th width="15%">Image</th>
                        <th>Summary</th>
                        <th width="10%">Status</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<!-- Blog Detail Modal -->
<div class="modal fade" id="blogDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="blogModalTitle"></h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <div class="modal-body" style="font-size:15px;line-height:1.8;color:#1f2933">
                <div id="blogModalImage" class="text-center mb-3"></div>
                <div id="blogModalDescription"></div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
.card { border-radius: 12px; }
.table td, .table th { vertical-align: middle; }
.dataTables_filter input {
    border-radius: 20px;
    padding: 6px 12px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {

    // DataTable
    let table = $('#blogTable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
            scrollX: true, 
        ajax: "{{ route('blogs.ajax') }}",
        columns: [
            { data: 'sr' },
            { data: 'title' },
            { data: 'image', orderable:false, searchable:false },
            { data: 'summary' },
            { data: 'status' },
            { data: 'action', orderable:false, searchable:false }
        ],
        language: {
            search: "",
            searchPlaceholder: "Search blogs..."
        }
    });

    // View detail
    $(document).on('click', '.view-detail', function () {
        let id = $(this).data('id');

        $.get('/blogs/' + id, function (res) {

            $('#blogModalTitle').text(res.title);

            $('#blogModalImage').html(
                res.image
                    ? `<img src="${res.image}" class="img-fluid rounded">`
                    : ''
            );

            $('#blogModalDescription').html(res.short_description);

            $('#blogDetailModal').modal('show');
        });
    });

    // Cleanup backdrop
    $('#blogDetailModal').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    // Delete blog
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete blog?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('/blogs/' + id, {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                }, function () {
                    Swal.fire('Deleted', '', 'success');
                    table.ajax.reload(null, false);
                });
            }
        });
    });

});
</script>
@endpush
