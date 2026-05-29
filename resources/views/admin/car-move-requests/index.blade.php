@extends('admin.layouts.dashboard')

@section('title', 'Car Move Requests')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="mb-4">
        <h3 class="mb-0">Car Move Requests</h3>
        <small class="text-muted">Requests submitted for car relocation</small>
    </div>

    <!-- Filters -->
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label fw-bold">Status</label>
                    <select id="statusFilter" class="form-control">
                        <option value="">All</option>
                        <option value="new">New</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Date</label>
                    <input type="date" id="singleDate" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">From Date</label>
                    <input type="date" id="fromDate" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">To Date</label>
                    <input type="date" id="toDate" class="form-control">
                </div>

                <div class="col-md-3 mt-2">
                    <button id="resetFilter" class="btn btn-secondary w-100">
                        Reset Filters
                    </button>
                </div>

                <div class="col-md-3 mt-2">
                    <button id="exportCsv" class="btn btn-outline-primary w-100 mb-2">
                        Export CSV
                    </button>
                    <button id="exportExcel" class="btn btn-outline-success w-100">
                        Export Excel
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="moveTable" class="table table-hover align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Pickup</th>
                        <th>Drop</th>
                        <th>Pickup State</th>
                        <th>Drop State</th>
                        <th>Vehicle Type</th>
                        <th>Budget</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Car Move Request</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Name:</strong> <span id="vName"></span></p>
                <p><strong>Email:</strong> <span id="vEmail"></span></p>
                <p><strong>Contact:</strong> <span id="vContact"></span></p>
                <p><strong>Pickup:</strong> <span id="vPickup"></span></p>
                <p><strong>Drop:</strong> <span id="vDrop"></span></p>
                <p><strong>Pickup State:</strong> <span id="vPickupState"></span></p>
                <p><strong>Drop State:</strong> <span id="vDropState"></span></p>
                <p><strong>Vehicle Type:</strong> <span id="vCarType"></span></p>
                <p><strong>Price Range:</strong> <span id="vPriceRange"></span></p>
                <p><strong>Status:</strong> <span id="vStatus"></span></p>
                <p><strong>Submitted At:</strong> <span id="vCreatedAt"></span></p>
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

    let table = $('#moveTable').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: "{{ route('car-move-requests.ajax') }}",
            data: function (d) {
                d.status      = $('#statusFilter').val();
                d.single_date = $('#singleDate').val();
                d.from_date   = $('#fromDate').val();
                d.to_date     = $('#toDate').val();
            }
        },
        rowCallback: function (row, data) {
            if (data.status.includes('New')) {
                $(row).addClass('table-warning');
            }
        },
        columns: [
            { data: 'sr' },
            { data: 'name' },
            { data: 'email' },
            { data: 'contact_no' },
            { data: 'pickup_location' },
            { data: 'drop_location' },
            { data: 'pickup_state' },
            { data: 'drop_state' },
            { data: 'car_type' },
            { data: 'price_range' },
            { data: 'status' },
            { data: 'action', orderable:false, searchable:false }
        ]
    });

    $('#statusFilter, #singleDate, #fromDate, #toDate').on('change', function () {
        table.ajax.reload();
    });

    $('#resetFilter').on('click', function () {
        $('#statusFilter, #singleDate, #fromDate, #toDate').val('');
        table.ajax.reload();
    });

    // View
    $(document).on('click', '.view-btn', function () {
        $.get('/car-move-requests/' + $(this).data('id'), function (res) {
            $('#vName').text(res.name);
            $('#vEmail').text(res.email);
            $('#vContact').text(res.contact_no);
            $('#vPickup').text(res.pickup_location);
            $('#vDrop').text(res.drop_location);
            $('#vPickupState').text(res.pickup_state || '-');
            $('#vDropState').text(res.drop_state || '-');
            $('#vCarType').text(res.car_type || '-');
            $('#vPriceRange').text(res.price_range || '-');
            $('#vStatus').text(res.status);
            $('#vCreatedAt').text(res.created_at || '-');
            $('#viewModal').modal('show');
        });
    });

    // Status change
    $(document).on('click', '.change-status', function () {
        let id = $(this).data('id');
        let status = $(this).data('status');

        $.post('/car-move-requests/' + id + '/status', {
            _token: '{{ csrf_token() }}',
            status: status
        }, function () {
            Swal.fire('Updated', 'Status updated successfully', 'success');
            table.ajax.reload(null,false);
        });
    });

});
</script>
@endpush
