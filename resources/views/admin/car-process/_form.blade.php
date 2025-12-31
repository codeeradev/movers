@csrf

<div class="row">

    <!-- Title -->
    <div class="col-md-6 mb-3">
        <label>Step Title</label>
        <input
            type="text"
            name="title"
            class="form-control"
            placeholder="e.g. Home Pickup"
            value="{{ old('title', $process->title ?? '') }}"
            required
        >
    </div>

    <!-- Sort Order -->
    <div class="col-md-3 mb-3">
        <label>Sort Order</label>
        <input
            type="number"
            name="sort_order"
            class="form-control"
            value="{{ old('sort_order', $process->sort_order ?? 0) }}"
        >
    </div>

    <!-- Status -->
    <div class="col-md-3 mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" {{ old('status', $process->status ?? 1) == 1 ? 'selected' : '' }}>
                Active
            </option>
            <option value="0" {{ old('status', $process->status ?? 1) == 0 ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>

    <!-- Description -->
    <div class="col-md-12 mb-3">
        <label>Description</label>
        <textarea
            name="description"
            class="form-control"
            rows="4"
            placeholder="Step description..."
        >{{ old('description', $process->description ?? '') }}</textarea>
    </div>

    <!-- Image -->
    <div class="col-md-6 mb-3">
        <label>Step Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <!-- Existing Image (Edit only) -->
    @if(!empty($process?->image))
        <div class="col-md-6 mb-3">
            <label>Current Image</label><br>
            <img 
                src="{{ asset('uploads/car-process/' . $process->image) }}" 
                height="80" 
                class="img-thumbnail"
            >
        </div>
    @endif

   

    <!-- Submit -->
    <div class="col-md-12 mt-3">
        <button type="submit" class="btn btn-primary">
            Save
        </button>
        <a href="{{ route('car-process.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

</div>
