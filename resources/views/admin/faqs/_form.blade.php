<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Question <span class="text-danger">*</span></label>
        <input type="text"
               name="question"
               class="form-control @error('question') is-invalid @enderror"
               value="{{ old('question', $faq->question ?? '') }}"
               placeholder="Enter FAQ question">
        @error('question')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Sort Order</label>
        <input type="number"
               name="sort_order"
               class="form-control @error('sort_order') is-invalid @enderror"
               value="{{ old('sort_order', $faq->sort_order ?? 0) }}"
               min="0"
               placeholder="0">
        @error('sort_order')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Apply To <span class="text-danger">*</span></label>
        <select name="scope" id="faqScope" class="form-control @error('scope') is-invalid @enderror">
            <option value="home" {{ old('scope', $faq->scope ?? 'home') === 'home' ? 'selected' : '' }}>Home Page</option>
            <option value="service" {{ old('scope', $faq->scope ?? 'home') === 'service' ? 'selected' : '' }}>Specific Service</option>
            <option value="blog" {{ old('scope', $faq->scope ?? 'home') === 'blog' ? 'selected' : '' }}>Specific Blog</option>
        </select>
        @error('scope')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-8 mb-3" id="faqServiceField">
        <label class="form-label">Service <span class="text-danger">*</span></label>
        <select name="service_id" class="form-control @error('service_id') is-invalid @enderror">
            <option value="">Select service</option>
            @foreach(($services ?? collect()) as $service)
                <option value="{{ $service->id }}" {{ old('service_id', $faq->service_id ?? '') == $service->id ? 'selected' : '' }}>
                    {{ $service->title }}
                </option>
            @endforeach
        </select>
        @error('service_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-muted">Only required when "Specific Service" is selected.</small>
    </div>

    <div class="col-md-8 mb-3" id="faqBlogField">
        <label class="form-label">Blog <span class="text-danger">*</span></label>
        <select name="blog_id" class="form-control @error('blog_id') is-invalid @enderror">
            <option value="">Select blog</option>
            @foreach(($blogs ?? collect()) as $blog)
                <option value="{{ $blog->id }}" {{ old('blog_id', $faq->blog_id ?? '') == $blog->id ? 'selected' : '' }}>
                    {{ $blog->title }}
                </option>
            @endforeach
        </select>
        @error('blog_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-muted">Only required when "Specific Blog" is selected.</small>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Answer <span class="text-danger">*</span></label>
        <textarea name="answer"
                  rows="8"
                  class="form-control @error('answer') is-invalid @enderror"
                  placeholder="Enter FAQ answer">{{ old('answer', $faq->answer ?? '') }}</textarea>
        @error('answer')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <small class="text-muted">Use plain text. Line breaks will be preserved on the frontend.</small>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-control @error('status') is-invalid @enderror">
            <option value="1" {{ old('status', $faq->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $faq->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const scopeSelect = document.getElementById('faqScope');
        const serviceField = document.getElementById('faqServiceField');
        const blogField = document.getElementById('faqBlogField');

        if (!scopeSelect || !serviceField || !blogField) {
            return;
        }

        const toggleServiceField = () => {
            serviceField.style.display = scopeSelect.value === 'service' ? 'block' : 'none';
            blogField.style.display = scopeSelect.value === 'blog' ? 'block' : 'none';
        };

        scopeSelect.addEventListener('change', toggleServiceField);
        toggleServiceField();
    })();
</script>
@endpush
