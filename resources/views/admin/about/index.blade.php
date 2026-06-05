@extends('admin.layouts.dashboard')

@section('title', 'About Section')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">About Section</h3>
            <small class="text-muted">Manage About Us content shown on website</small>
        </div>
        <a href="{{ route('about.create') }}" class="btn btn-primary btn-sm">
            <i class="mdi mdi-plus"></i> Add About Content
        </a>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table id="aboutTable" class="table table-hover align-middle w-100">
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

</div>

<!-- About Detail Modal -->
<div class="modal fade" id="aboutDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalTitle"></h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <div class="modal-body" style="font-size:15px;line-height:1.8;color:#1f2933">
                <div id="aboutModalImage" class="text-center mb-3"></div>
                <div id="aboutModalSubtitle" class="mb-3"></div>
                <div id="aboutModalDescription"></div>
                <div id="aboutModalVision" class="mt-3"></div>
                <div id="aboutModalMission" class="mt-3"></div>
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
.table td, .table th {
    vertical-align: middle;
    white-space: normal;
    word-break: break-word;
}
.table-responsive {
    overflow-x: auto;
}
#aboutTable td {
    max-width: 1px;
}
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
    let table = $('#aboutTable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: "{{ route('about.ajax') }}",
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
            searchPlaceholder: "Search about content..."
        }
    });

    // View detail
    $(document).on('click', '.view-detail', function () {
        let id = $(this).data('id');

        $.get('/about/' + id, function (res) {

            $('#aboutModalTitle').text(res.title);
            $('#aboutModalSubtitle').text(res.subtitle || '');

            $('#aboutModalImage').html(
                res.image
                    ? `<img src="${res.image}" class="img-fluid rounded">`
                    : ''
            );

            $('#aboutModalDescription').html(res.description);
            $('#aboutModalVision').html(res.vision ? `<h5>Vision</h5><p>${res.vision}</p>` : '');
            $('#aboutModalMission').html(res.mission ? `<h5>Mission</h5><p>${res.mission}</p>` : '');

            const aboutModal = new bootstrap.Modal(document.getElementById('aboutDetailModal'));
            aboutModal.show();
        });
    });

    // Delete
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete content?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('/about/' + id, {
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
