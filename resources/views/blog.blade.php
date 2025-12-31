@extends('layouts.app')

@section('title', 'Blog')

@section('content')

<section class="hero-wrap hero-wrap-2 js-fullheight"
         style="background-image: url('{{ asset('images/bg_2.jpg') }}');"
         data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
      <div class="col-md-9 ftco-animate pb-5">
        <p class="breadcrumbs">
          <span class="mr-2">
            <a href="{{ url('/') }}">Home <i class="ion-ios-arrow-forward"></i></a>
          </span>
          <span>Blog <i class="ion-ios-arrow-forward"></i></span>
        </p>
        <h1 class="mb-3 bread">Read our blog</h1>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section">
  <div class="container">
    <div class="row d-flex justify-content-center">

      @forelse($blogs as $blog)
      <div class="col-md-10 text-center d-flex ftco-animate mb-5">
        <div class="blog-entry justify-content-end w-100">

          <!-- Image -->
          <a href="{{ route('blog.single', $blog->slug) }}"
             class="block-20 img"
             style="background-image: url('{{ asset('uploads/blogs/'.$blog->image) }}');">
          </a>

          <div class="text pt-4">

            <!-- Meta -->
            <div class="meta mb-3">
              <div>
                <a href="#">{{ $blog->created_at->format('M d, Y') }}</a>
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
              {{ Str::limit(strip_tags($blog->summary), 200) }}
            </p>

            <!-- Continue -->
            <p>
              <a href="{{ route('blog.single', $blog->slug) }}" class="btn-custom">
                Continue <span class="icon-long-arrow-right"></span>
              </a>
            </p>

          </div>
        </div>
      </div>
      @empty
        <div class="col-12 text-center">
          <p>No blogs found.</p>
        </div>
      @endforelse

    </div>

    <!-- Pagination -->
    <div class="row mt-5">
      <div class="col text-center">
        {{ $blogs->links('pagination::bootstrap-4') }}
      </div>
    </div>

  </div>
</section>

@endsection
