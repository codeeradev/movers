
<div class="row g-3">

    <!-- Name -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">Name</label>
        <input type="text" name="name" class="form-control"
            value="{{ old('name', $enquiry->name ?? '') }}" required>
    </div>

    <!-- Phone -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">Phone</label>
        <input type="text" name="phone" class="form-control"
            value="{{ old('phone', $enquiry->phone ?? '') }}" required>
    </div>

    <!-- Email -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" class="form-control"
            value="{{ old('email', $enquiry->email ?? '') }}">
    </div>

    <!-- Sector -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">Sector</label>
        <select name="sector" class="form-control filter-field" required>
            <option value="">Select Sector</option>
            @foreach($sectors as $sector)
                <option value="{{ $sector->id }}"
                    {{ old('sector', $enquiry->sector ?? '') == $sector->id ? 'selected':'' }}>
                    {{ $sector->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Category -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">Category</label>
        <select name="category_id" id="category_id" class="form-control filter-field" required>
            <option value="">Select Category</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ old('category_id', $enquiry->category_id ?? '') == $cat->id ? 'selected':'' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Subcategory -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">Subcategory</label>
        <select name="subcategory_id" id="subcategory_id" class="form-control filter-field" required>
            <option value="">Select Subcategory</option>

            @if(!empty($enquiry))
                @foreach($subcategories->where('category_id', $enquiry->category_id) as $sub)
                    <option value="{{ $sub->id }}"
                        {{ $enquiry->subcategory_id == $sub->id ? 'selected':'' }}>
                        {{ $sub->name }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

  @if(($enquiry->type ?? $type) == 2)
<div class="col-md-6">
    <label for="plotSelect" class="form-label fw-semibold">Plot No</label>
    <select id="plotSelect" name="property_id" class="form-select" style="padding-top:10px; padding-bottom:10px;">
        <option value="">Select Plot</option>
    </select>
</div>
@endif



    <!-- Property Type -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">Property Type</label>
        <input type="text" name="property_type" class="form-control"
            value="{{ old('property_type', $enquiry->property_type ?? '') }}">
    </div>

    <!-- Message -->
    <div class="col-md-12">
        <label class="form-label fw-semibold">Message</label>
        <textarea name="message" rows="3" class="form-control">
            {{ old('message', $enquiry->message ?? '') }}
        </textarea>
    </div>

<input type="hidden" name="type" value="{{ $enquiry->type ?? $type }}">


    <!-- Status -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">Status</label>
        <select name="status" class="form-control">
            @foreach(config('constants.inquiry_status') as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

</div>


@push('scripts')
<script>
$('#category_id').change(function () {
    var category_id = $(this).val();
    $('#subcategory_id').html('<option>Loading...</option>');

    $.get('/get-subcategories/' + category_id, function (res) {
        let html = '<option value="">Select Subcategory</option>';
        res.forEach(function (data) {
            html += `<option value="${data.id}">${data.name}</option>`;
        });
        $('#subcategory_id').html(html);
    });
});
</script>

<script>
$(document).ready(function () {

    let selectedPlotId = "{{ $enquiry->property_id ?? '' }}";

    $('#plotSelect').select2({
        placeholder: "Search Plot No...",
        width: "100%"
    });

    function loadPlots() {

        let sector = $("select[name='sector']").val();
        let category = $("select[name='category_id']").val();
        let subcategory = $("select[name='subcategory_id']").val();
       console.log(subcategory);


        if (!sector || !category || !subcategory) {
            $('#plotSelect').html('<option value="">Select Plot</option>');
            return;
        }

        $.ajax({
            url: "{{ route('properties.filter') }}",
            type: "GET",
            data: {
                sector_id: sector,
                category_id: category,
                subcategory_id: subcategory,
            },
            success: function (res) {

                let html = '<option value="">Select Plot</option>';
                res.forEach(item => {
                    html += `<option value="${item.id}">${item.property_number}</option>`;
                });

                $('#plotSelect').html(html);

                // Set selected in edit mode
                if (selectedPlotId) {
                    $('#plotSelect').val(selectedPlotId).trigger('change');
                }
            }
        });
    }

    // Trigger load on dropdown change
    $('.filter-field').on("change", loadPlots);

    // Auto load on edit page
    loadPlots();
});
</script>

@endpush
