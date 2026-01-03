@extends('admin.layouts.dashboard')

@section('title', 'Contact Messages')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="mb-4">
        <h3 class="mb-0">Contact Messages</h3>
        <small class="text-muted">Messages submitted from website contact form</small>
    </div>

    <!-- 🔍 Filters -->
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="row g-3 align-items-end">

                <!-- Status -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Status</label>
                    <select id="statusFilter" class="form-control">
                        <option value="">All</option>
                        <option value="new">New</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <!-- Single Date -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Date</label>
                    <input type="date" id="singleDate" class="form-control">
                </div>

                <!-- From Date -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">From Date</label>
                    <input type="date" id="fromDate" class="form-control">
                </div>

                <!-- To Date -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">To Date</label>
                    <input type="date" id="toDate" class="form-control">
                </div>

                <!-- Reset -->
                <div class="col-md-3 mt-2">
                    <button id="resetFilter" class="btn btn-secondary w-100">
                        Reset Filters
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- 📋 Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="contactTable" class="table table-hover align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th width="10%">Status</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<!-- 👁 View Modal -->
<div class="modal fade" id="messageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Contact Message</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Name:</strong> <span id="mName"></span></p>
                <p><strong>Email:</strong> <span id="mEmail"></span></p>
                <p><strong>Phone:</strong> <span id="mPhone"></span></p>
                <hr>
                <p id="mMessage"></p>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {

    let table = $('#contactTable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: "{{ route('contact-messages.ajax') }}",
            data: function (d) {
                d.status      = $('#statusFilter').val();
                d.single_date = $('#singleDate').val();
                d.from_date   = $('#fromDate').val();
                d.to_date     = $('#toDate').val();
            }
        },
        columns: [
            { data: 'sr' },
            { data: 'name' },
            { data: 'email' },
            { data: 'phone' },
            {
                data: 'message',
                render: data => data.length > 50 ? data.substr(0,50)+'...' : data
            },
            { data: 'status' },
            { data: 'action', orderable:false, searchable:false }
        ]
    });

    // 🔄 Reload on filter change
    $('#statusFilter, #singleDate, #fromDate, #toDate').on('change', function () {
        table.ajax.reload();
    });

    // 🔁 Reset filters
    $('#resetFilter').on('click', function () {
        $('#statusFilter').val('');
        $('#singleDate').val('');
        $('#fromDate').val('');
        $('#toDate').val('');
        table.ajax.reload();
    });

    // 👁 View
    $(document).on('click', '.view-detail', function () {
        let id = $(this).data('id');

        $.get('/contact-messages/' + id, function (res) {
            $('#mName').text(res.name);
            $('#mEmail').text(res.email);
            $('#mPhone').text(res.phone);
            $('#mMessage').text(res.message);
            $('#messageModal').modal('show');
        });
    });

    // ✅ Mark inactive
    $(document).on('click', '.mark-inactive', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Mark as inactive?',
            icon: 'question',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('/contact-messages/' + id + '/inactive', {
                    _token: '{{ csrf_token() }}'
                }, function () {
                    Swal.fire('Updated', 'Marked as inactive', 'success');
                    table.ajax.reload(null,false);
                });
            }
        });
    });

    // 🗑 Delete
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete message?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/contact-messages/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function () {
                        Swal.fire('Deleted', '', 'success');
                        table.ajax.reload(null,false);
                    }
                });
            }
        });
    });

});
</script>
@endpush
