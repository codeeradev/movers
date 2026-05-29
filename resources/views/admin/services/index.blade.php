@extends('admin.layouts.dashboard')

@section('title', 'Services Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Services Management</h3>
            <small class="text-muted">Manage homepage and service page content</small>
        </div>
        <a href="{{ route('admin-services.create') }}" class="btn btn-primary btn-sm">
            <i class="mdi mdi-plus"></i> Add Service
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="serviceTable" class="table table-hover align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Title</th>
                        <th width="15%">Image</th>
                        <th>Description</th>
                        <th width="10%">Status</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="serviceDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size:15px;line-height:1.8;color:#1f2933">
                <div id="serviceModalImage" class="text-center mb-3"></div>
                <div id="serviceModalDescription"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    .dataTables_filter input { border-radius: 20px; padding: 6px 12px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {
    let table = $('#serviceTable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        scrollX: true,
        ajax: "{{ route('admin-services.ajax') }}",
        columns: [
            { data: 'sr' },
            { data: 'title' },
            { data: 'image', orderable:false, searchable:false },
            { data: 'description' },
            { data: 'status' },
            { data: 'action', orderable:false, searchable:false }
        ],
        language: {
            search: "",
            searchPlaceholder: "Search services..."
        }
    });

    $(document).on('click', '.view-detail', function () {
        let id = $(this).data('id');

        $.get('/admin-services/' + id, function (res) {
            $('#serviceModalTitle').text(res.title);
            $('#serviceModalImage').html(
                res.image ? `<img src="${res.image}" class="img-fluid rounded">` : ''
            );
            $('#serviceModalDescription').html(res.description);
            $('#serviceDetailModal').modal('show');
        });
    });

    $('#serviceDetailModal').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete service?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('/admin-services/' + id, {
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
