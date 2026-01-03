@csrf

<!-- Flag to check if it is new plot -->
<input type="hidden" name="is_new_plot" id="is_new_plot" value="false">

<div class="row g-3">

  {{-- Client Name --}}
  <div class="col-md-6">
    <label class="form-label">Client Name</label>
    <input type="text" name="client_name" class="form-input"
      placeholder="Enter client name"
      value="{{ old('client_name', $requestData->client_name ?? '') }}" required>
  </div>

  {{-- Contact Number --}}
  <div class="col-md-6">
    <label class="form-label">Contact Number</label>
    <input type="text" name="contact_number" class="form-input"
      placeholder="Enter contact number"
      value="{{ old('contact_number', $requestData->contact_number ?? '') }}" required>
  </div>

  {{-- Request Type --}}
  <div class="col-md-6">
    <label class="form-label">Request Type</label>
    <div class="dropdown-wrapper">
      <select name="type" id="requestType" class="form-input" required>
        <option value="">Select Request Type</option>
        @foreach(config('constants.request_types') as $key => $value)
          <option value="{{ $key }}" {{ old('type', $requestData->type ?? '') == $key ? 'selected' : '' }}>
            {{ $value }}
          </option>
        @endforeach
      </select>
    </div>
  </div>

  {{-- Sector --}}
  <div class="col-md-6">
    <label class="form-label">Sector</label>
    <div class="dropdown-wrapper">
      <select name="sector_id" class="form-input filter-dropdown" required>
        <option value="">Select Sector</option>
        @foreach($sectors as $sector)
          <option value="{{ $sector->id }}" {{ old('sector_id', $requestData->sector_id ?? '') == $sector->id ? 'selected' : '' }}>
            {{ $sector->name }}
          </option>
        @endforeach
      </select>
    </div>
  </div>

  {{-- Category --}}
  <div class="col-md-6">
    <label class="form-label">Category</label>
    <div class="dropdown-wrapper">
      <select name="category_id" class="form-input filter-dropdown" required>
        <option value="">Select Category</option>
        @foreach($categories as $category)
          <option value="{{ $category->id }}" {{ old('category_id', $requestData->category_id ?? '') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
          </option>
        @endforeach
      </select>
    </div>
  </div>

  {{-- Subcategory --}}
  <div class="col-md-6">
    <label class="form-label">Subcategory</label>
    <div class="dropdown-wrapper">
      <select name="subcategory_id" class="form-input filter-dropdown" required>
        <option value="">Select Subcategory</option>
        @foreach($subcategories as $subcategory)
          <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $requestData->subcategory_id ?? '') == $subcategory->id ? 'selected' : '' }}>
            {{ $subcategory->name }}
          </option>
        @endforeach
      </select>
    </div>
  </div>

  {{-- Location --}}
  <div class="col-md-6">
    <label class="form-label mt-2">Location</label>
    <input type="text" name="location" class="form-input"
      placeholder="Enter location"
      value="{{ old('location', $requestData->location ?? '') }}" required>
  </div>


  {{-- ⭐⭐⭐ PLOT SECTION (Only real change) ⭐⭐⭐ --}}
  <div class="col-md-6" id="plotSection" style="display:none;">

    <label class="form-label d-flex justify-content-between align-items-center mt-2">
        <span>Plot No</span>

        <!-- Add New Button -->
        @if(empty($requestData))
        <button type="button" id="addNewPlotBtn" class="btn btn-sm btn-outline-primary" style="padding:3px 10px;">
            Add New
        </button>
        @endif
    </label>

    <!-- Your original Select2 dropdown -->
    <select id="plotSelect" name="property_id" class="form-input">
        <option value="">Select Plot</option>
    </select>

    <!-- New Plot Input -->
    <input type="text"
           id="newPlotInput"
           name="new_property_id"
           class="form-input mt-2"
           placeholder="Enter new plot number"
           style="display:none;">
  </div>



  {{-- Status --}}
  <div class="col-md-6">
    <label class="form-label">Status</label>
    <div class="dropdown-wrapper">
      <select name="status" class="form-input" required>
        <option value="">Select Status</option>
        @foreach(config('constants.request_statuses') as $key => $value)
          <option value="{{ $key }}" {{ old('status', $requestData->status ?? '') == $key ? 'selected' : '' }}>
            {{ $value }}
          </option>
        @endforeach
      </select>
    </div>
  </div>

  {{-- Notes --}}
  <div class="col-md-12">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-input" rows="3"
      placeholder="Additional notes...">{{ old('notes', $requestData->notes ?? '') }}</textarea>
  </div>

</div>


<div class="mt-4 d-flex justify-content-end gap-2">
  <a href="{{ route('property-requests.index') }}" class="btn btn-outline-secondary">Cancel</a>
  <button type="submit" class="btn btn-primary">
    {{ isset($requestData) ? 'Update Request' : 'Create Request' }}
  </button>
</div>


<style>
  .form-label {
    font-weight: 600;
    color: #111827;
    font-size: 0.9rem;
  }

  .form-input {
    width: 100%;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background-color: #fff;
    font-size: 0.95rem;
    padding: 10px 12px;
    height: 42px;
    transition: 0.2s;
  }

  /* Your original Select2 styling preserved */
  .select2-container .select2-selection--single {
      height: 42px !important;
      border: 1px solid #d1d5db !important;
      border-radius: 6px !important;
      padding: 6px 10px !important;
      display: flex !important;
      align-items: center !important;
  }
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
/* Show/Hide Plot Section */
document.addEventListener('DOMContentLoaded', function () {
    const requestType = document.getElementById('requestType');
    const plotSection = document.getElementById('plotSection');

    function togglePlot() {
        plotSection.style.display = (requestType.value == "2") ? "block" : "none";
    }

    requestType.addEventListener('change', togglePlot);
    togglePlot();
});
</script>


<script>
$(document).ready(function () {

    let selectedPlotId = "{{ $requestData->property_id ?? '' }}";

    // Initialize Select2 (unchanged)
    $('#plotSelect').select2({
        placeholder: "Search Plot No...",
        width: "100%"
    });



    /* ----------------- ADD NEW BUTTON LOGIC ----------------- */
    $("#addNewPlotBtn").on("click", function () {

        // Hide Select2 UI
        $("#plotSelect").closest(".select2-container").hide();

        // Show input
        $("#newPlotInput").show().attr("required", true);

        $("#is_new_plot").val("true");
    });


    /* ----------------- USER SELECTED EXISTING PLOT ----------------- */
    $("#plotSelect").on("change", function () {

        // Hide new input
        $("#newPlotInput").hide().removeAttr("required");

        // Show dropdown back
        $("#plotSelect").closest(".select2-container").show();

        $("#is_new_plot").val("false");
    });



    /* ----------------- LOAD PLOTS VIA AJAX ----------------- */
    function loadPlots() {

        let sector = $("select[name='sector_id']").val();
        let category = $("select[name='category_id']").val();
        let subcategory = $("select[name='subcategory_id']").val();

        if (!sector || !category || !subcategory) {
            $('#plotSelect').html('<option value="">Select Plot</option>');
            return;
        }

        $.ajax({
            url: "{{ route('properties.filter') }}",
            type: "GET",
            data: { sector_id: sector, category_id: category, subcategory_id: subcategory },
            success: function (res) {

                let html = '<option value="">Select Plot</option>';

                res.forEach(item => {
                    html += `<option value="${item.id}">${item.property_number}</option>`;
                });

                $("#plotSelect").html(html);

                if (selectedPlotId) {
                    $("#plotSelect").val(selectedPlotId).trigger("change");
                }
            }
        });
    }

    $(".filter-dropdown").on("change", loadPlots);

    loadPlots();
});
</script>
