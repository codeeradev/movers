@csrf

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-semibold">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $service->title ?? '') }}" required>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $service->sort_order ?? 0) }}" min="0">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-control" required>
                    <option value="1" {{ old('status', $service->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $service->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-semibold">Image</label>
                <input type="file" name="image" class="form-control">
                @if(!empty($service?->image))
                    <img src="{{ asset('uploads/services/'.$service->image) }}" alt="Service" class="mt-2 rounded" width="140">
                @endif
            </div>

            <div class="col-md-12">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" id="description" class="form-control" rows="8">{{ old('description', $service->description ?? '') }}</textarea>
                <small class="text-muted">You can format text and paste rich HTML content here.</small>
            </div>
        </div>
    </div>
<div class="card mt-4 shadow-sm border-0">
    <div class="card-header bg-light">
        <h5 class="mb-0" style="color: #000;">SEO Settings</h5>
    </div>

    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label fw-semibold">SEO Title</label>
                <input
                    type="text"
                    name="seo_title"
                    class="form-control"
                    
                    value="{{ old('seo_title', $service->seo_title ?? '') }}"
                    placeholder="Enter SEO title">
               
            </div>

            <div class="col-md-12">
                <label class="form-label fw-semibold">SEO Description</label>
                <textarea
                    name="seo_description"
                    class="form-control"
                    rows="4"
                   
                    placeholder="Enter SEO description">{{ old('seo_description', $service->seo_description ?? '') }}</textarea>
                
            </div>
        </div>
    </div>
</div>
    <div class="card-footer bg-white text-end">
        <button type="submit" class="btn btn-primary px-4">{{ $buttonText }}</button>
        <a href="{{ route('admin-services.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
    $(function () {
        $('#description').summernote({
            height: 260,
            placeholder: 'Write service details...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'table']],
                ['view', ['codeview']]
            ]
        });

        $('#description').closest('form').on('submit', function () {
            $('#description').val($('#description').summernote('code'));
        });
    });
</script>
@endpush
