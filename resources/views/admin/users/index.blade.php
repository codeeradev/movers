@extends('admin.layouts.dashboard')
@section('title', 'Employee Details')
@section('content')
<div class="card shadow-lg border-0 rounded-4">
  <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
    <h4 class="mb-0 fw-bold">👤 Employee List</h4>
    <a href="{{ route('employees.create') }}" class="btn btn-light btn-sm fw-semibold shadow-sm">
      <i class="bi bi-plus-circle"></i> Add New Employee
    </a>
  </div>

  <div class="card-body  rounded-bottom-4">
    <div class="table-responsive">
      <table id="userTable" class="table table-striped table-hover align-middle text-center shadow-sm rounded-3" style="width:100%">
        <thead class="table-primary text-dark">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Role</th>

            <th>Email</th>
            <th>Phone</th>
           
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
<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  .card {
    border-radius: 1.2rem;
  }
  .dataTables_wrapper .dataTables_filter input {
    border-radius: 0.5rem;
    border: 1px solid #ced4da;
    padding: 6px 10px;
  }
  .dataTables_wrapper .dataTables_length select {
    border-radius: 0.5rem;
  }
  .btn-light:hover {
    background-color: #f8f9fa;
  }
  .table-hover tbody tr:hover {
    background-color: #eef6ff;
  }
  .badge {
    font-size: 0.8rem;
  }
</style>

<script>
$(document).ready(function() {
  $('#userTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("employees.data") }}', // route for AJAX data
    columns: [
      { data: 'id', name: 'id' },
      { data: 'name', name: 'name' },
      { data: 'role', name: 'role', orderable: false, searchable: false },

      { data: 'email', name: 'email' },
      { data: 'phone', name: 'phone' },
      
      { 
        data: 'status', 
        name: 'status',
        orderable: false,
        searchable: false,
        render: function(data) {
          return data; // formatted badge from controller
        }
      },
      { 
        data: 'actions',
        name: 'actions',
        orderable: false,
        searchable: false,
        render: function(data) {
          return data; // HTML buttons from controller
        }
      }
    ],
    columnDefs: [
      { targets: '_all', className: 'align-middle' }
    ],
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search employees...",
      lengthMenu: "_MENU_ entries per page"
    },
    pageLength: 10,
    order: [[0, 'desc']]
  });
});

// Delete confirmation
function deleteUser(id) {
  Swal.fire({
    title: "Are you sure?",
    text: "This employee will be permanently deleted.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "Cancel",
    confirmButtonColor: "#d33",
    cancelButtonColor: "#6c757d"
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: 'employees/' + id,
        type: 'DELETE',
        data: { _token: '{{ csrf_token() }}' },
        success: function() {
          $('#userTable').DataTable().ajax.reload();
          Swal.fire("Deleted!", "The employee has been deleted.", "success");
        },
        error: function() {
          Swal.fire("Error!", "Failed to delete the employee.", "error");
        }
      });
    }
  });
}
</script>
@endpush
