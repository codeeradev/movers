@csrf

<div class="card">
    <div class="card-body">

        <!-- Blog Title -->
        <div class="form-group mb-3">
            <label>Blog Title</label>
            <input type="text"
                   name="title"
                   class="form-control"
                   placeholder="Enter blog title"
                   value="{{ old('title', $blog->title ?? '') }}"
                   required>
        </div>

        <!-- Meta Title -->
        <div class="form-group mb-3">
            <label>Meta Title</label>
            <input type="text"
                   name="meta_title"
                   class="form-control"
                   placeholder="Enter meta title"
                   value="{{ old('meta_title', $blog->meta_title ?? '') }}">
            <small class="text-muted">Optional SEO title for search engines.</small>
        </div>

        <!-- Meta Description -->
        <div class="form-group mb-3">
            <label>Meta Description</label>
            <textarea
                name="meta_description"
                rows="3"
                class="form-control"
                placeholder="Write meta description"
            >{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
            <small class="text-muted">Recommended 140-160 characters.</small>
        </div>

        <!-- Blog Image -->
        <div class="form-group mb-3">
            <label>Blog Image</label>
            <input type="file" name="image" class="form-control">

            @if(!empty($blog->image))
                <img src="{{ asset('uploads/blogs/'.$blog->image) }}"
                     class="mt-2 rounded"
                     width="120">
            @endif
        </div>

        <!-- Summary (50 Words Limit) -->
        <div class="form-group mb-3">
            <label>Summary</label>
            <textarea
                name="summary"
                id="summary"
                rows="3"
                class="form-control"
                placeholder="Write short summary (max 50 words)"
            >{{ old('summary', $blog->summary ?? '') }}</textarea>

            <small class="text-muted">
                Only 50 words allowed.
                <span id="wordCount">0</span>/50
            </small>
        </div>

        <!-- Description (CKEditor) -->
        <div class="form-group mb-3">
            <label>Description</label>
            <textarea
                name="short_description"
                id="content"
                rows="6"
                class="form-control"
            >{{ old('short_description', $blog->short_description ?? '') }}</textarea>
        </div>

        <!-- Status -->
        <div class="form-group mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1"
                    {{ old('status', $blog->status ?? 1) == 1 ? 'selected' : '' }}>
                    Active
                </option>
                <option value="0"
                    {{ old('status', $blog->status ?? 1) == 0 ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
        </div>

        <div class="alert alert-light border mb-3">
            Blog FAQs are managed from FAQ Management by selecting the Blog scope and choosing a specific blog.
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-primary">
            {{ $buttonText }}
        </button>

        <a href="{{ route('blogs.index') }}" class="btn btn-secondary ms-2">
            Back
        </a>

    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>

<script>
    /* CKEditor */
    let editor;
    ClassicEditor
        .create(document.querySelector('#content'))
        .then(e => editor = e)
        .catch(error => console.error(error));

    document.addEventListener('submit', function () {
        if (editor) {
            document.querySelector('#content').value = editor.getData();
        }
    });

    /* Summary Word Limit (50 words hard limit) */
    const summary = document.getElementById('summary');
    const wordCount = document.getElementById('wordCount');
    const maxWords = 50;

    function updateWordCount() {
        let words = summary.value.trim().split(/\s+/).filter(w => w.length > 0);

        if (words.length > maxWords) {
            summary.value = words.slice(0, maxWords).join(' ');
            words = summary.value.split(/\s+/);
        }

        wordCount.innerText = words.length;
    }

    summary.addEventListener('input', updateWordCount);
    updateWordCount(); // for edit page
</script>
@endpush
