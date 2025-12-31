<div class="row">

    <!-- Name -->
    <div class="col-md-6 mb-3">
        <label>Client Name</label>
        <input
            type="text"
            name="name"
            class="form-control"
            placeholder="e.g. Roger Scott"
            value="{{ old('name', $testimonial->name ?? '') }}"
            required
        >
    </div>

    <!-- Position -->
    <div class="col-md-6 mb-3">
        <label>Position / Designation</label>
        <input
            type="text"
            name="position"
            class="form-control"
            placeholder="e.g. Marketing Manager"
            value="{{ old('position', $testimonial->position ?? '') }}"
        >
    </div>

    <!-- Message -->
    <div class="col-md-12 mb-3">
        <label>Testimonial Message</label>
        <textarea
            name="message"
            class="form-control"
            rows="4"
            placeholder="Client feedback..."
            required
        >{{ old('message', $testimonial->message ?? '') }}</textarea>
    </div>

    <!-- Image -->
    <div class="col-md-6 mb-3">
        <label>Client Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <!-- Existing Image -->
    @if(!empty($testimonial?->image))
        <div class="col-md-6 mb-3">
            <label>Current Image</label><br>
            <img 
                src="{{ asset('uploads/testimonials/'.$testimonial->image) }}" 
                height="80" 
                class="img-thumbnail"
            >
        </div>
    @endif

    <!-- Status -->
    <div class="col-md-3 mb-3">
        <label>Status</label>
         <select name="status" id="status" class="form-control" required>
        <option value="">Select Status</option>
        @foreach(config('constants.status') as $key => $label)
            <option value="{{ $key }}" {{ old('status', $testimonial->status ?? '') == $key ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    </div>

    <!-- Sort Order -->
    <div class="col-md-3 mb-3">
        <label>Sort Order</label>
        <input
            type="number"
            name="sort_order"
            class="form-control"
            value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}"
        >
    </div>

    <!-- Submit -->
    <div class="col-md-12 mt-3">
        <button type="submit" class="btn btn-primary">
            Save
        </button>
        <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

</div>
