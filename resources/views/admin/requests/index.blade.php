@extends('admin.layouts.dashboard')
@section('title', 'Request List')
@section('content')
<div class="card shadow-lg border-0 rounded-4">
  <div class="card-header bg-primary text-white rounded-top-4 d-flex flex-wrap justify-content-between align-items-center gap-2 py-3 px-4">
    <h4 class="mb-0 fw-bold">Request List</h4>

    <a href="{{ route('property-requests.create') }}" class="btn btn-light btn-sm fw-semibold shadow-sm">
      <i class="bi bi-plus-circle"></i> Add New
    </a>
  </div>

  <div class="card-body rounded-bottom-4">
    <div class="table-responsive">
      <table id="requestTable" class="table table-striped table-hover align-middle text-center shadow-sm rounded-3 w-100">
        <thead class="table-primary text-dark">
          <tr>
            <th>Sr No</th>
            <th>Client Name</th>
            <th>Type</th>
            <th>Contact</th>
            <th>Sector</th>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Status</th>
            <th>Actions</th>
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

  .dataTables_wrapper .dataTables_filter input {
      border-radius: 0.5rem;
      border: 1px solid #ced4da;
      padding: 6px 10px;
  }

  .dataTables_wrapper .dataTables_length select {
      border-radius: 0.5rem;
  }

  .table-striped tbody tr:nth-child(odd) {
      background-color: #f8f9ff !important;
  }

  .table-hover tbody tr:hover {
      background-color: #e9f2ff !important;
  }

  table.dataTable tbody td { vertical-align: middle !important; }
</style>

<script>
$(document).ready(function () {

  const table = $('#requestTable').DataTable({
    processing: true,
    serverSide: true,
  ajax: {
  url: '{{ route("property-requests.data") }}',
  data: function (d) {
    d.type = new URLSearchParams(window.location.search).get('type'); 
  }
},

    columns: [
      {
        data: null,
        render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1,
        orderable: false,
        searchable: false
      },
      { data: 'client_name', name: 'client_name' },
      { data: 'type', name: 'type' },
      { data: 'contact_number', name: 'contact_number' },

      { data: 'sector', name: 'sector' },
      { data: 'category', name: 'category' },
      { data: 'subcategory', name: 'subcategory' },

      { data: 'status', name: 'status', orderable: false, searchable: false },
      { data: 'actions', name: 'actions', orderable: false, searchable: false },
    ],

    columnDefs: [
      { targets: '_all', className: 'align-middle' }
    ],

    pageLength: 10
  });

  // DELETE HANDLER
  $(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');

    Swal.fire({
      title: "Are you sure?",
      text: "This request will be permanently deleted.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
      confirmButtonColor: "#d33",
      cancelButtonColor: "#6c757d"
    }).then((result) => {
      if (result.isConfirmed) {

        $.ajax({
          url: '{{ url("property-requests") }}/' + id,
          type: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            _method: 'DELETE'
          },
          success: function () {
            table.ajax.reload(null, false);

            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: 'Request deleted successfully.',
              confirmButtonColor: '#198754'
            });
          },
          error: function () {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'Failed to delete the request.',
              confirmButtonColor: '#dc3545'
            });
          }
        });

      }
    });
  });

});
</script>
@endpush
