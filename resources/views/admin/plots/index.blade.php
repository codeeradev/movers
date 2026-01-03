@extends('admin.layouts.dashboard')
@section('title', 'Property List')
@section('content')

<!-- ========================= MAIN CONTAINER ========================= -->
<div class="modern-property-container">
  
  <!-- Page Header with Gradient -->
  <div class="page-header-modern">
    <div class="header-content">
      <div class="header-title-group">
        <h2 class="page-title">
          <i class="bi bi-buildings"></i>
          Property Management
        </h2>
        <p class="page-subtitle">Manage and track all your properties in one place</p>
      </div>
      <a href="{{ route('plots.create') }}" class="btn-add-modern">
        <i class="bi bi-plus-circle-fill"></i>
        <span>Add Property</span>
      </a>
    </div>
  </div>

  <!-- ========================= FILTERS & ACTIONS CARD ========================= -->
  <div class="filters-card-modern">
    
    <!-- Import Section -->
    <div class="import-section-modern">
      <div class="section-label">
        <i class="bi bi-cloud-arrow-up-fill"></i>
        <span>Bulk Import</span>
      </div>
      <form id="importForm" enctype="multipart/form-data" class="import-form-modern">
        @csrf
        <div class="file-input-wrapper">
          <input type="file" name="file" id="importFile" class="file-input-hidden" accept=".xlsx,.xls" required>
          <label for="importFile" class="file-input-label">
            <i class="bi bi-file-earmark-excel"></i>
            <span class="file-name-display">Choose Excel File</span>
          </label>
        </div>
        <button type="submit" id="importBtn" class="btn-import-modern">
          <i class="bi bi-upload"></i>
          Import
        </button>
        <a href="{{ asset('plots_import_template.xlsx') }}" class="btn-template-modern">
          <i class="bi bi-download"></i>
          Template
        </a>
      </form>
    </div>

    <!-- Filters Section -->
    <div class="filters-section-modern">
      <div class="section-label">
        <i class="bi bi-funnel-fill"></i>
        <span>Filters</span>
      </div>
      <div class="filters-grid">
        
        <div class="filter-item">
          <label class="filter-label">Sector</label>
          <div class="select-wrapper">
            <select id="filterSector" class="filter-select">
              <option value="">All Sectors</option>
              @foreach($sectors as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
              @endforeach
            </select>
            <i class="bi bi-chevron-down select-icon"></i>
          </div>
        </div>

        <div class="filter-item">
          <label class="filter-label">Category</label>
          <div class="select-wrapper">
            <select id="filterCategory" class="filter-select">
              <option value="">All Categories</option>
              @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
              @endforeach
            </select>
            <i class="bi bi-chevron-down select-icon"></i>
          </div>
        </div>

        <div class="filter-item">
          <label class="filter-label">Sub Category</label>
          <div class="select-wrapper">
            <select id="filterSubcategory" class="form-control">
        <option value="">All Sub Categories</option>
    </select>
            <i class="bi bi-chevron-down select-icon"></i>
          </div>
        </div>

        <div class="filter-item">
          <label class="filter-label">Plot No</label>
          <div class="select-wrapper">
            <select id="filterPlot" class="filter-select filter-plot">
              <option value="">All Plots</option>
            </select>
            <i class="bi bi-chevron-down select-icon"></i>
          </div>
        </div>

        <div class="filter-item">
          <label class="filter-label">Property Status</label>
          <div class="select-wrapper">
            <select id="filterStatus" class="filter-select">
              <option value="">All Status</option>
              @foreach(config('constants.property_status') as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
            </select>
            <i class="bi bi-chevron-down select-icon"></i>
          </div>
        </div>

      </div>
    </div>

  </div>

  <!-- ========================= DATA TABLE CARD ========================= -->
  <div class="table-card-modern">
    <div class="table-responsive">
      <table id="propertyTable" class="table-modern" style="width:100%">
        <thead>
          <tr>
            <th>Sr</th>
            <th>Owner</th>
            <th>DOB</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Property No</th>
            <th>Location</th>
            <th>Price</th>
            <th>Active</th>
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
/* ========================= MODERN DESIGN SYSTEM ========================= */
:root {
  --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
  --danger-gradient: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
  --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  --card-bg: #ffffff;
  --surface-bg: #f8f9fa;
  --text-primary: #1a202c;
  --text-secondary: #64748b;
  --border-color: #e2e8f0;
  --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
  --shadow-md: 0 4px 12px rgba(0,0,0,0.08);
  --shadow-lg: 0 10px 30px rgba(0,0,0,0.12);
  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 16px;
}

body {
  background: var(--surface-bg);
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.modern-property-container {
  padding: 2rem;
  max-width: 1600px;
  margin: 0 auto;
}

/* ========================= PAGE HEADER ========================= */
.page-header-modern {
  background: var(--primary-gradient);
  border-radius: var(--radius-lg);
  padding: 2.5rem;
  margin-bottom: 2rem;
  box-shadow: var(--shadow-lg);
  position: relative;
  overflow: hidden;
}

.page-header-modern::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -10%;
  width: 400px;
  height: 400px;
  background: rgba(255,255,255,0.1);
  border-radius: 50%;
  animation: float 6s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(5deg); }
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  z-index: 1;
}

.page-title {
  color: white;
  font-size: 2rem;
  font-weight: 700;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.page-title i {
  font-size: 2.25rem;
}

.page-subtitle {
  color: rgba(255,255,255,0.9);
  margin: 0.5rem 0 0 0;
  font-size: 0.95rem;
}

.btn-add-modern {
  background: white;
  color: #667eea;
  border: none;
  padding: 0.875rem 1.75rem;
  border-radius: var(--radius-md);
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
  box-shadow: var(--shadow-md);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-add-modern:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-lg);
  color: #667eea;
}

/* ========================= FILTERS CARD ========================= */
.filters-card-modern {
  background: var(--card-bg);
  border-radius: var(--radius-lg);
  padding: 2rem;
  margin-bottom: 2rem;
  box-shadow: var(--shadow-md);
  border: 1px solid var(--border-color);
}

.section-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 1.25rem;
  font-size: 1rem;
}

.section-label i {
  color: #667eea;
  font-size: 1.25rem;
}

/* Import Section */
.import-section-modern {
  margin-bottom: 2rem;
  padding-bottom: 2rem;
  border-bottom: 2px solid var(--border-color);
}

.import-form-modern {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  align-items: center;
}

.file-input-wrapper {
  position: relative;
  flex: 1;
  min-width: 250px;
}

.file-input-hidden {
  opacity: 0;
  position: absolute;
  z-index: -1;
}

.file-input-label {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.875rem 1.25rem;
  background: var(--surface-bg);
  border: 2px dashed var(--border-color);
  border-radius: var(--radius-md);
  cursor: pointer;
  transition: all 0.3s ease;
  font-weight: 500;
  color: var(--text-secondary);
}

.file-input-label:hover {
  border-color: #667eea;
  background: #f0f3ff;
}

.file-input-label i {
  color: #11998e;
  font-size: 1.5rem;
}

.btn-import-modern,
.btn-template-modern {
  padding: 0.875rem 1.5rem;
  border-radius: var(--radius-md);
  font-weight: 600;
  border: none;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
}

.btn-import-modern {
  background: var(--success-gradient);
  color: white;
  box-shadow: var(--shadow-sm);
}

.btn-import-modern:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
}

.btn-template-modern {
  background: var(--warning-gradient);
  color: white;
  box-shadow: var(--shadow-sm);
}

.btn-template-modern:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
  color: white;
}

/* Filters Grid */
.filters-section-modern {
  margin-top: 2rem;
}

.filters-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.25rem;
}

.filter-item {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.filter-label {
  font-size: 0.875rem;
  font-weight: 600;
  color: var(--text-primary);
  margin: 0;
}

.select-wrapper {
  position: relative;
}

.filter-select {
  width: 100%;
  padding: 0.75rem 2.5rem 0.75rem 1rem;
  border: 2px solid var(--border-color);
  border-radius: var(--radius-md);
  background: white;
  color: var(--text-primary);
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.3s ease;
  appearance: none;
}

.filter-select:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.select-icon {
  position: absolute;
  right: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: var(--text-secondary);
  pointer-events: none;
  transition: transform 0.3s ease;
}

.filter-select:focus + .select-icon {
  transform: translateY(-50%) rotate(180deg);
}

/* ========================= DATA TABLE ========================= */
.table-card-modern {
  background: var(--card-bg);
  border-radius: var(--radius-lg);
  padding: 2rem;
  box-shadow: var(--shadow-md);
  border: 1px solid var(--border-color);
}

.table-modern {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
}

.table-modern thead {
  background: linear-gradient(135deg, #667eea15, #764ba215);
}

.table-modern thead th {
  padding: 1rem;
  font-weight: 600;
  color: var(--text-primary);
  border-bottom: 2px solid #667eea;
  text-align: left;
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.table-modern tbody tr {
  transition: all 0.3s ease;
  border-bottom: 1px solid var(--border-color);
}

.table-modern tbody tr:hover {
  background: #f8f9ff;
  transform: scale(1.01);
  box-shadow: var(--shadow-sm);
}

.table-modern tbody td {
  padding: 1rem;
  color: var(--text-primary);
  font-size: 0.9rem;
}

/* DataTables Custom Styling */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
  margin-bottom: 1.5rem;
}

.dataTables_wrapper .dataTables_filter input {
  border: 2px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 0.625rem 1rem;
  margin-left: 0.5rem;
  transition: all 0.3s ease;
}

.dataTables_wrapper .dataTables_filter input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
  border-radius: var(--radius-sm);
  margin: 0 0.25rem;
  padding: 0.5rem 0.875rem;
  border: 1px solid var(--border-color);
  background: white;
  transition: all 0.3s ease;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: #667eea;
  color: white !important;
  border-color: #667eea;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: var(--primary-gradient);
  color: white !important;
  border-color: transparent;
}

/* ========================= PROGRESS CIRCLE ========================= */
.progress-circle {
  position: relative;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background: conic-gradient(#11998e 0deg, #e9ecef 0deg);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  box-shadow: var(--shadow-md);
}

.progress-circle::before {
  content: "";
  position: absolute;
  width: 95px;
  height: 95px;
  background: #fff;
  border-radius: 50%;
}

.progress-text {
  position: absolute;
  font-size: 1.25rem;
  font-weight: 700;
  color: #11998e;
}

/* ========================= RESPONSIVE ========================= */
@media (max-width: 768px) {
  .modern-property-container {
    padding: 1rem;
  }

  .page-header-modern {
    padding: 1.5rem;
  }

  .header-content {
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
  }

  .page-title {
    font-size: 1.5rem;
  }

  .filters-grid {
    grid-template-columns: 1fr;
  }

  .import-form-modern {
    flex-direction: column;
    align-items: stretch;
  }

  .file-input-wrapper {
    min-width: 100%;
  }
}

/* ========================= ANIMATIONS ========================= */
@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.filters-card-modern,
.table-card-modern {
  animation: slideIn 0.5s ease;
}
</style>
<script>
$('#filterCategory').on('change', function () {

    let category_id = $(this).val();

    // पहले dropdown खाली करो
    $('#filterSubcategory').html('<option value="">All Sub Categories</option>');

    if (category_id) {
        $.ajax({
            url: '/get-subcategories/' + category_id,
            type: 'GET',
            success: function (data) {

                data.forEach(function (sc) {
                    $('#filterSubcategory').append(
                        '<option value="' + sc.id + '">' + sc.name + '</option>'
                    );
                });

            }
        });
    }
});
</script>

<script>
$(document).ready(function () {
    // File input display name
    $('#importFile').on('change', function() {
        const fileName = this.files[0]?.name || 'Choose Excel File';
        $('.file-name-display').text(fileName);
    });

    function loadDashboardPlots() {
        $.ajax({
            url: "{{ route('properties.filter') }}",
            type: "GET",
            data: {
                sector_id: $("#filterSector").val(),
                category_id: $("#filterCategory").val(),
                subcategory_id: $("#filterSubcategory").val(),
                property_status: $("#filterStatus").val()
            },
            success: function (res) {
                let html = '<option value="">All Plots</option>';
                res.forEach(item => {
                    html += `<option value="${item.id}">${item.property_number}</option>`;
                });
                $("#filterPlot").html(html);
            }
        });
    }

    $("#filterSector, #filterCategory, #filterSubcategory, #filterStatus")
        .on("change", loadDashboardPlots);

    const table = $('#propertyTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('plots.data') }}",
            data: function (d) {
                d.sector_id = $("#filterSector").val();
                d.category_id = $("#filterCategory").val();
                d.subcategory_id = $("#filterSubcategory").val();
                d.property_status = $("#filterStatus").val();
                d.property_number = $("#filterPlot").val();
            }
        },
        columns: [
            {
                data: 'id',
                name: 'sr_no',
                render: (data, type, row, meta) => meta.row + 1,
                orderable: false,
                searchable: false
            },
            { data: 'owner_name', name: 'owner_name' },
            { data: 'dob', name: 'dob' },
            { data: 'contact_number', name: 'contact_number' },
            { data: 'property_status', name: 'property_type' },
            { data: 'property_number', name: 'property_number' },
            { data: 'location', name: 'location' },
            { data: 'price', name: 'price' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        columnDefs: [{ targets: '_all', className: 'align-middle' }],
        pageLength: 10
    });

    $("#filterSector, #filterCategory, #filterSubcategory, #filterPlot, #filterStatus")
        .on("change", function () {
            table.ajax.reload(null, false);
        });

    // File Upload with Progress
    $('#importForm').on('submit', function(e) {
        e.preventDefault();
        const fileInput = $('#importFile')[0];
        const file = fileInput.files[0];
        if (!file) return Swal.fire('No File', 'Please select a file to upload.', 'warning');

        const formData = new FormData(this);
        const xhr = new XMLHttpRequest();
        let cancelled = false;
        let startTime = Date.now();

        Swal.fire({
            title: 'Uploading...',
            html: `
                <div style="display:flex; flex-direction:column; align-items:center; gap:15px;">
                    <div class="progress-circle" id="progressCircle">
                        <div class="progress-text" id="progressPercent">0%</div>
                    </div>
                    <div id="uploadSpeed" style="font-size:0.9rem; color:#555;"></div>
                    <div id="timeRemaining" style="font-size:0.9rem; color:#777;"></div>
                </div>
            `,
            showCancelButton: true,
            cancelButtonText: 'Cancel Upload',
            cancelButtonColor: '#dc3545',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading()
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.cancel) {
                cancelled = true;
                xhr.abort();
                Swal.fire({
                    icon: 'info',
                    title: 'Upload Cancelled',
                    text: 'You cancelled the upload.',
                    confirmButtonColor: '#6c757d'
                });
            }
        });

        xhr.open('POST', '{{ route("plots.import") }}', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable && !cancelled) {
                const percent = Math.round((e.loaded / e.total) * 100);
                const elapsed = (Date.now() - startTime) / 1000;
                const speed = (e.loaded / (1024 * 1024)) / elapsed;
                const remainingBytes = e.total - e.loaded;
                const remainingTime = remainingBytes / (speed * 1024 * 1024);

                const circle = document.getElementById('progressCircle');
                const angle = percent * 3.6;
                circle.style.background = `conic-gradient(#11998e ${angle}deg, #e9ecef ${angle}deg)`;
                $('#progressPercent').text(percent + '%');
                $('#uploadSpeed').text(`Speed: ${speed.toFixed(2)} MB/s`);
                $('#timeRemaining').text(`Time remaining: ${remainingTime > 0 ? remainingTime.toFixed(1) + 's' : '...'}`);
            }
        });

        xhr.onload = function() {
            if (cancelled) return;
            try {
                const response = JSON.parse(xhr.responseText);
                if (xhr.status === 200 && response.success) {
                    $('#progressCircle').css('background', 'conic-gradient(#11998e 360deg, #11998e 360deg)');
                    $('#progressPercent').html('<i class="bi bi-check-circle-fill text-success" style="font-size:2rem;"></i>');
                    $('#uploadSpeed').text('');
                    $('#timeRemaining').text('');
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Import Successful',
                            html: `<div class="text-start">
                                    <p><b>Message:</b> ${response.message || 'File imported successfully!'}</p>
                                    ${response.total ? `<p><b>Records Imported:</b> ${response.total}</p>` : ''}
                                </div>`,
                            confirmButtonColor: '#11998e'
                        });
                        $('#importFile').val('');
                        $('.file-name-display').text('Choose Excel File');
                        table.ajax.reload(null, false);
                    }, 1000);
                } else {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Import Failed',
                        html: `<div class="text-start text-danger">${response.message || 'File import failed.'}</div>`,
                        confirmButtonColor: '#dc3545'
                    });
                }
            } catch {
                Swal.close();
                Swal.fire('Error', 'Invalid server response.', 'error');
            }
        };

        xhr.onerror = function() {
            if (cancelled) return;
            Swal.close();
            Swal.fire('Error', 'Network error during upload.', 'error');
        };

        xhr.send(formData);
    });

    // Delete Property
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            text: "This property will be permanently deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("plots") }}/' + id,
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                    success: function() {
                        table.ajax.reload(null, false);
                        Swal.fire({ 
                            icon: 'success', 
                            title: 'Deleted!', 
                            text: 'The property has been deleted successfully.', 
                            confirmButtonColor: '#11998e' 
                        });
                    },
                    error: function() {
                        Swal.fire({ 
                            icon: 'error', 
                            title: 'Error!', 
                            text: 'Failed to delete the property.', 
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