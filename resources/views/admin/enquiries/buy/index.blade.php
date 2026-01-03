@extends('admin.layouts.dashboard')
@section('title', ($type == 1 ? 'Buy Inquiry List' : 'Sell Inquiry List'))


@section('content')
<div class="card shadow-lg border-0 rounded-4">

    <!-- ========================= PAGE HEADER ========================= -->
   <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center px-4 py-3">
    <h4 class="mb-0 fw-bold">
        {{ $type == 1 ? 'Buy Inquiry List' : 'Sell Inquiry List' }}
    </h4>

    <a href="{{ route('inquiries.create', ['type' => $type]) }}" class="btn btn-light btn-sm fw-semibold shadow-sm">
        <i class="bi bi-plus-circle"></i> Add New
    </a>
</div>


    <!-- ========================= FILTER SECTION ========================= -->
    <div class="p-3 border-bottom">
        <div class="row g-3 align-items-end">

            <div class="col-lg-6 col-md-12">
                <input type="text" id="searchByPhone" class="form-control form-control-sm" placeholder="Search by phone...">
            </div>

            <div class="col-lg-6 col-md-12">
                <select id="filterStatus" class="form-control form-control-sm w-auto ms-auto">
                    <option value="">Priority (All)</option>
                     @foreach(config('constants.inquiry_status') as $key => $label)
        <option value="{{ $key }}">{{ $label }}</option>
    @endforeach
                </select>
            </div>

        </div>
    </div>

    <!-- ========================= TABLE SECTION ========================= -->
    <div class="card-body rounded-bottom-4">
        <div class="table-responsive">
            <table id="buyInquiryTable" class="table table-striped table-hover align-middle text-center shadow-sm rounded-3" style="width:100%">
                <thead class="table-primary text-dark">
                    <tr>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Property Type</th>
                        <th>Sector</th>
                        <th>Priority</th>
                        <th>Date</th>
                        @if(auth()->user()->role == 1)
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>
@endsection


@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  .card { border-radius: 1.2rem; }
  .table-hover tbody tr:hover { background-color: #eef6ff; }
</style>

<script>
$(document).ready(function () {

    const table = $('#buyInquiryTable').DataTable({
        processing: true,
        serverSide: true,
      ajax: {
    url: '{{ route("enquiries.buy.data") }}',

            data: function (d) {
                d.status = $('#filterStatus').val();
                d.phone = $('#searchByPhone').val();
                  d.type   = "{{ $type }}";
            }
        },
        columns: [
            {
                data: null,
                render: (data, type, row, meta) => meta.row + 1,
                orderable: false
            },
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'property_type', name: 'property_type' },
            { data: 'sector', name: 'sector' },

            {
                data: 'status',
                render: function (value) {

                    const labels = {
                        1: { text: "Urgent", class: "danger" },
                        2: { text: "High Priority", class: "warning text-dark" },
                        3: { text: "Medium Priority", class: "info" },
                        4: { text: "Low Priority", class: "success" },
                         5: { text: "Closed",           class: "secondary" }
                    };

                    let badge = labels[value];

                    return `<span class="badge bg-${badge.class}">${badge.text}</span>`;
                }
            },

            { data: 'created_at', name: 'created_at' },

            @if(auth()->user()->role == 1)
            {
                data: 'actions',
                orderable: false,
                searchable: false
            }
            @endif
        ],
        pageLength: 10
    });

    // Search by phone
    $('#searchByPhone').keyup(() => table.ajax.reload());

    // Filter by status
    $('#filterStatus').change(() => table.ajax.reload());

    // Delete Inquiry
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: "Delete?",
            text: "Are you sure you want to delete this inquiry?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonColor: "#6c757d",
            confirmButtonColor: "#d33"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: '{{ url("inquiries") }}/' + id,
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },

                    success: function () {
                        table.ajax.reload(null, false);
                        Swal.fire("Deleted!", "Inquiry deleted successfully.", "success");
                    }
                });

            }
        });
    });

});
</script>
@endpush
