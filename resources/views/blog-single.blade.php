@extends('layouts.app')

@section('title', $blog->meta_title ?: $blog->title)
@section('meta_description', $blog->meta_description ?: Str::limit(strip_tags($blog->summary ?? ''), 160))

@section('content')

<!-- Hero -->
<section class="hero-wrap hero-wrap-2 js-fullheight"
         style="background-image: url('{{ asset('uploads/blogs/'.$blog->image) }}');"
         data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
      <div class="col-md-9 ftco-animate pb-5">
        <p class="breadcrumbs">
          <span class="mr-2">
            <a href="{{ url('/') }}">Home <i class="ion-ios-arrow-forward"></i></a>
          </span>
          <span class="mr-2">
            <a href="{{ route('blog') }}">Blog <i class="ion-ios-arrow-forward"></i></a>
          </span>
          <span>{{ $blog->title }}</span>
        </p>
        <h1 class="mb-3 bread">{{ $blog->title }}</h1>
      </div>
    </div>
  </div>
</section>

<!-- Blog Detail -->
<section class="ftco-section ftco-degree-bg">
  <div class="container">
    <div class="row">

      <!-- MAIN CONTENT -->
      <div class="col-md-8 order-md-last ftco-animate">

        <!-- Meta -->
        <div class="mb-3 text-muted">
          <span>{{ $blog->created_at->format('M d, Y') }}</span> |
          <span>{{ $blog->author ?? 'Admin' }}</span>
        </div>

        <!-- Summary -->
        @if($blog->summary)
          <p class="font-italic">
            {{ $blog->summary }}
          </p>
        @endif

        <!-- Image inside content -->
        <p>
          <img src="{{ asset('uploads/blogs/'.$blog->image) }}"
               alt="{{ $blog->title }}"
               class="img-fluid rounded">
        </p>

        <!-- Description (CKEditor HTML) -->
        <div class="blog-content">
          {!! $blog->short_description !!}
        </div>

      </div>

      <!-- SIDEBAR -->
      <div class="col-md-4 sidebar ftco-animate">

        <!-- Search -->
        <div class="sidebar-box">
          <form action="{{ route('blog') }}" method="GET" class="search-form">
            <div class="form-group">
              <span class="icon icon-search"></span>
              <input type="text"
                     name="q"
                     class="form-control"
                     placeholder="Search blog">
            </div>
          </form>
        </div>

        <!-- Recent Blogs -->
        <div class="sidebar-box ftco-animate">
          <h3>Recent Blog</h3>

          @foreach($recentBlogs as $recent)
          <div class="block-21 mb-4 d-flex">
            <a class="blog-img mr-4"
               style="background-image: url('{{ asset('uploads/blogs/'.$recent->image) }}');">
            </a>
            <div class="text">
              <h3 class="heading">
                <a href="{{ route('blog.single', $recent->slug) }}">
                  {{ Str::limit($recent->title, 60) }}
                </a>
              </h3>
              <div class="meta">
                <div>
                  <a href="#">
                    <span class="icon-calendar"></span>
                    {{ $recent->created_at->format('M d, Y') }}
                  </a>
                </div>
                <div>
                  <a href="#">
                    <span class="icon-person"></span>
                    {{ $recent->author ?? 'Admin' }}
                  </a>
                </div>
              </div>
            </div>
          </div>
          @endforeach

        </div>

      </div>
      <!-- END SIDEBAR -->

    </div>
  </div>
</section>

@include('sections.faq', [
  'faqs' => $blogFaqs,
  'faqTitle' => $blog->title . ' FAQs',
  'faqIntro' => 'Helpful answers related to this blog topic and the services discussed here.',
  'faqBadges' => ['Relevant Answers', 'Expert Guidance', 'Quick Help'],
])

@endsection
