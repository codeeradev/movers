@extends('admin.layouts.dashboard')
@section('title', 'Message History')

@section('content')
<div class="card shadow-lg border-0 rounded-4">

  <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center py-3 px-4">
    <h4 class="mb-0 fw-bold">Message History</h4>
  </div>

  <div class="card-body rounded-bottom-4">
    <div class="table-responsive">
      <table id="smsHistoryTable"
             class="table table-striped table-hover align-middle text-center shadow-sm rounded-3 w-100">

        <thead class="table-primary text-dark">
          <tr>
            <th>Sr No</th>
            <th>Owner Name</th>
            <th>Property No</th>
            <th>Address</th>
            <th>Location</th>
            <th>Mobile</th>
            <th>Type</th>
            <th>Status</th>
            <th>Sent At</th>
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

  table.dataTable tbody td {
      vertical-align: middle !important;
  }
</style>

<script>
$(document).ready(function () {

  $('#smsHistoryTable').DataTable({
    processing: true,
    serverSide: true,

    ajax: {
      url: "{{ route('sms.history.data') }}"
    },

    columns: [
      {
        data: null,
        render: (data, type, row, meta) =>
          meta.row + meta.settings._iDisplayStart + 1,
        orderable: false,
        searchable: false
      },

      { data: 'owner_name', name: 'owner_name' },
      { data: 'property_number', name: 'property_number' },
      { data: 'address', name: 'address' },
      { data: 'location', name: 'location' },
      { data: 'mobile', name: 'mobile' },

      {
        data: 'type',
        name: 'type',
        render: data =>
          `<span class="badge bg-info text-dark">${data}</span>`
      },

      {
        data: 'status',
        name: 'status',
        orderable: false,
        searchable: false,
        render: data =>
          data === 'Sent'
            ? '<span class="badge bg-success">Sent</span>'
            : '<span class="badge bg-danger">Failed</span>'
      },

      { data: 'created_at', name: 'created_at' }
    ],

    pageLength: 10
  });

});
</script>
@endpush
