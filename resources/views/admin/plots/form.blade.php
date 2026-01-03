<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">{{ isset($property) ? 'Update Property' : 'Create Property' }}</h4>
      <p class="card-description">Complete the details below</p>

      <form action="{{ isset($property) ? route('plots.update', $property->id) : route('plots.store') }}"
            method="POST" enctype="multipart/form-data" class="forms-sample">
        @csrf
        @if(isset($property))
          @method('PUT')
        @endif

        <!-- Owner Information -->
        <h5 class="text-primary fw-bold mt-4 mb-3 border-start border-4 ps-2">Owner Information</h5>
        <div class="row">
          <div class="form-group col-md-6">
            <label>Owner Name <span class="text-danger">*</span></label>
            <input type="text" name="owner_name" class="form-control"
                   value="{{ old('owner_name', $property->owner_name ?? '') }}" required>
          </div>

          <div class="form-group col-md-6">
            <label>Father's Name</label>
            <input type="text" name="father_name" class="form-control"
                   value="{{ old('father_name', $property->father_name ?? '') }}">
          </div>

          <div class="form-group col-md-6">
            <label>Contact Number</label>
            <input type="text" name="contact_number" class="form-control"
                   value="{{ old('contact_number', $property->contact_number ?? '') }}">
          </div>

          <div class="form-group col-md-6">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $property->email ?? '') }}">
          </div>

          <div class="form-group col-md-6">
            <label>Date of Birth</label>
            <input type="text" id="dob" name="dob" class="form-control"
                   value="{{ old('dob', isset($property->dob) ? \Carbon\Carbon::parse($property->dob)->format('d-m-Y') : '') }}">
          </div>
        </div>

        <!-- Property Details -->
        <h5 class="text-primary fw-bold mt-4 mb-3 border-start border-4 ps-2">Property Details</h5>
        <div class="row">
          <div class="form-group col-md-6">
            <label>Address</label>
            <textarea name="address" rows="2" class="form-control"
                      placeholder="Enter full address">{{ old('address', $property->address ?? '') }}</textarea>
          </div>

      <div class="form-group col-md-6">
    <label>Property Type</label>
    <input type="text"
           name="property_type"
           class="form-control"
           value="{{ old('property_type', $property->property_type ?? '') }}"
           placeholder="Enter property type (e.g., Plot, House, Flat, Shop)">
</div>


          <div class="form-group col-md-6">
            <label>Property Number</label>
            <input type="text" name="property_number" class="form-control"
                   placeholder="Enter property number"
                   value="{{ old('property_number', $property->property_number ?? '') }}">
          </div>

          <div class="form-group col-md-6">
            <label>Plot Size</label>
            <input type="text" name="plot_size" class="form-control"
                   placeholder="e.g. 200 sq. yards"
                   value="{{ old('plot_size', $property->plot_size ?? '') }}">
          </div>

          <div class="form-group col-md-6">
            <label>Sector</label>
            <select id="sector_id" name="sector_id" class="form-control">
              <option value="">Select Sector</option>
              @foreach($sectors as $sector)
                <option value="{{ $sector->id }}" {{ old('sector_id', $property->sector_id ?? '') == $sector->id ? 'selected' : '' }}>
                  {{ $sector->name }}
                </option>
              @endforeach
              <option value="other">Other</option>
            </select>
            <input type="text" id="sector_custom" name="sector_custom"
                   class="form-control mt-2 d-none" placeholder="Enter new sector name">
          </div>

          <div class="form-group col-md-6">
            <label>Category</label>
            <select id="category_id" name="category_id" class="form-control">
              <option value="">Select Category</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $property->category_id ?? '') == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
              <option value="other">Other</option>
            </select>
            <input type="text" id="category_custom" name="category_custom"
                   class="form-control mt-2 d-none" placeholder="Enter new category name">
          </div>

          <div class="form-group col-md-6">
            <label>Subcategory</label>
            <select id="subcategory_id" name="subcategory_id" class="form-control">
              <option value="">Select Subcategory</option>
              @foreach($subcategories as $subcategory)
                <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}"
                        {{ old('subcategory_id', $property->subcategory_id ?? '') == $subcategory->id ? 'selected' : '' }}>
                  {{ $subcategory->name }}
                </option>
              @endforeach
              <option value="other">Other</option>
            </select>
            <input type="text" id="subcategory_custom" name="subcategory_custom"
                   class="form-control mt-2 d-none" placeholder="Enter new subcategory name">
          </div>
<div class="form-group col-md-6">
    <label for="property_status">Property Status</label>
    <select name="property_status" id="property_status" class="form-control">
        <option value="">Select Status</option>

        @foreach(config('constants.property_status') as $key => $value)
            <option value="{{ $key }}" 
                {{ old('property_status', $property->property_status ?? '') == $key ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>
</div>

       <div class="form-group col-md-6">
    <label>Ownership Type</label>
    <input type="text" 
           name="ownership_type" 
           class="form-control"
           value="{{ old('ownership_type', $property->ownership_type ?? '') }}"
           placeholder="Enter ownership type (e.g., Freehold, Leasehold, etc.)">
</div>


          <div class="form-group col-md-6">
            <label>Location <span class="text-danger">*</span></label>
            <input type="text" name="location" class="form-control"
                   placeholder="Enter location"
                   value="{{ old('location', $property->location ?? '') }}" required>
          </div>

          <div class="form-group col-md-6">
            <label>Landmark</label>
            <input type="text" name="landmark" class="form-control"
                   placeholder="Nearby landmark"
                   value="{{ old('landmark', $property->landmark ?? '') }}">
          </div>

          <div class="form-group col-md-6">
            <label>Price (₹)</label>
            <input type="number" step="0.01" name="price" class="form-control"
                   placeholder="Enter property price"
                   value="{{ old('price', $property->price ?? '') }}">
          </div>
        </div>

        <!-- Media & Description -->
        <h5 class="text-primary fw-bold mt-4 mb-3 border-start border-4 ps-2">Media & Description</h5>
        <div class="row">
          <div class="form-group col-md-6">
            <label>Property Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            @if(!empty($property->image))
              <div class="mt-2">
                <img src="{{ asset('properties/'.$property->image) }}" width="130"
                     class="rounded-3 border shadow-sm">
              </div>
            @endif
          </div>

          <div class="form-group col-md-12">
            <label>Description</label>
            <textarea name="description" rows="4" class="form-control"
                      placeholder="Write about this property...">{{ old('description', $property->description ?? '') }}</textarea>
          </div>

          <div class="form-group col-md-3">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="1" {{ old('status', $property->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
              <option value="0" {{ old('status', $property->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mr-2 mt-4">
          <i class="bi bi-save me-1"></i> {{ isset($property) ? 'Update Property' : 'Create Property' }}
        </button>
        <a href="{{ route('plots.index') }}" class="btn btn-light mt-4">Cancel</a>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
  flatpickr("#dob", { dateFormat: "d-m-Y", maxDate: "today", allowInput: true });

  const handleDropdown = (dropdownId, inputId) => {
    const dropdown = document.getElementById(dropdownId);
    const input = document.getElementById(inputId);
    dropdown.addEventListener('change', () => {
      if (dropdown.value === 'other') {
        input.classList.remove('d-none');
        input.required = true;
      } else {
        input.classList.add('d-none');
        input.required = false;
        input.value = '';
      }
    });
  };

  handleDropdown('sector_id', 'sector_custom');
  handleDropdown('category_id', 'category_custom');
  handleDropdown('subcategory_id', 'subcategory_custom');
  handleDropdown('ownership_type', 'ownership_custom');
  handleDropdown('property_type', 'property_type_custom');

  const categorySelect = document.getElementById('category_id');
  const subcategorySelect = document.getElementById('subcategory_id');
  function filterSubcategories() {
    const selectedCategory = categorySelect.value;
    Array.from(subcategorySelect.options).forEach(opt => {
      if (opt.value === '' || opt.dataset.category === selectedCategory || opt.value === 'other') {
        opt.style.display = 'block';
      } else {
        opt.style.display = 'none';
      }
    });
  }
  categorySelect.addEventListener('change', filterSubcategories);
  filterSubcategories();
});
</script>
@endpush
