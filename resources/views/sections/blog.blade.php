<section class="ftco-section">
  <div class="container">

    <!-- Heading -->
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 heading-section text-center ftco-animate">
        <span class="subheading">Blog</span>
        <h2>Car Transportation Insights</h2>
      </div>
    </div>

    <div class="row d-flex">

      @forelse($blogs as $blog)
      <div class="col-md-4 d-flex ftco-animate">
        <div class="blog-entry justify-content-end">

          <!-- Image -->
          <a href="{{ route('blog.single', $blog->slug) }}"
             class="block-20"
             style="background-image: url('{{ asset('uploads/blogs/'.$blog->image) }}');">
          </a>

          <div class="text pt-4">

            <!-- Meta -->
            <div class="meta mb-3">
              <div>
                <a href="#">
                  {{ $blog->created_at->format('M d, Y') }}
                </a>
              </div>
              <div>
                <a href="#">{{ $blog->author ?? 'Admin' }}</a>
              </div>
            </div>

            <!-- Title -->
            <h3 class="heading mt-2">
              <a href="{{ route('blog.single', $blog->slug) }}">
                {{ $blog->title }}
              </a>
            </h3>

            <!-- Summary -->
            <p>
              {{ Str::limit(strip_tags($blog->summary), 120) }}
            </p>

          </div>
        </div>
      </div>
      @empty
        <div class="col-12 text-center">
          <p>No blogs available.</p>
        </div>
      @endforelse

    </div>

    <!-- View More Button -->
    <div class="row mt-5">
      <div class="col text-center">
        <a href="{{ route('blog') }}" class="btn btn-primary px-4 py-2">
          View More Blogs
        </a>
      </div>
    </div>

  </div>
</section>
@push('styles')
<style>
.blog-entry .block-20 {
    height: 220px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
@endpush
