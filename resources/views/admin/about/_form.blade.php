@csrf

<div class="card shadow-sm border-0">
    <div class="card-body">

        <!-- Title -->
        <div class="form-group">
            <label class="font-weight-bold">Title</label>
            <input
                type="text"
                name="title"
                class="form-control"
                value="{{ old('title', $about->title ?? '') }}"
                placeholder="Enter title"
                required
            >
        </div>

        <!-- Subtitle -->
        <div class="form-group">
            <label class="font-weight-bold">Subtitle</label>
            <input
                type="text"
                name="subtitle"
                class="form-control"
                value="{{ old('subtitle', $about->subtitle ?? '') }}"
                placeholder="Enter subtitle (e.g. About Us)"
            >
        </div>

        <!-- Description -->
        <div class="form-group">
            <label class="font-weight-bold">Description</label>
            <textarea
                name="description"
                id="description"
                class="form-control"
                rows="6"
            >{{ old('description', $about->description ?? '') }}</textarea>
        </div>

        <!-- Vision -->
        <div class="form-group">
            <label class="font-weight-bold">Vision</label>
            <textarea
                name="vision"
                id="vision"
                class="form-control"
                rows="4"
            >{{ old('vision', $about->vision ?? '') }}</textarea>
        </div>

        <!-- Mission -->
        <div class="form-group">
            <label class="font-weight-bold">Mission</label>
            <textarea
                name="mission"
                id="mission"
                class="form-control"
                rows="4"
            >{{ old('mission', $about->mission ?? '') }}</textarea>
        </div>


        <!-- Image -->
        <div class="form-group">
            <label class="font-weight-bold">Image</label>
            <input type="file" name="image" class="form-control">

            @if(!empty($about?->image))
                <div class="mt-2">
                    <img
                        src="{{ asset('uploads/about/'.$about->image) }}"
                        height="80"
                        class="img-thumbnail"
                    >
                </div>
            @endif
        </div>

        <!-- Status -->
        <div class="form-group">
            <label class="font-weight-bold">Status</label>
            <select name="status" class="form-control" required>
                <option value="1" {{ old('status', $about->status ?? 1) == 1 ? 'selected' : '' }}>
                    Active
                </option>
                <option value="0" {{ old('status', $about->status ?? 1) == 0 ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
        </div>

    </div>

    <div class="card-footer text-right bg-white">
        <button type="submit" class="btn btn-primary px-4">
            Save
        </button>
        <a href="{{ route('about.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </div>
</div>
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        ['description', 'vision', 'mission'].forEach(function (fieldId) {
            const element = document.querySelector('#' + fieldId);
            if (element) {
                ClassicEditor
                    .create(element)
                    .catch(error => {
                        console.error('CKEditor init error for #' + fieldId, error);
                    });
            }
        });
    });
</script>
@endpush
