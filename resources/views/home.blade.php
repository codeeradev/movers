@extends('layouts.app')

@section('title', 'Laxis Cargo Movers | Best Cargo Movers in Bangalore | Vehicle Transportation Services in Bangalore')

@section('content')
    @include('sections.hero-wrap')
    @include('sections.search')
    @include('sections.services')
    @include('sections.choose')
    @include('sections.statistics')
    <!-- @include('sections.work') -->
    @include('sections.testimonials')
    @include('sections.about-us')
    @include('sections.blog')
    @include('sections.faq', ['faqs' => $homeFaqs, 'faqTitle' => 'Move With Confidence', 'faqIntro' => 'Common questions about our moving services, process, and support.'])
@endsection

@push('scripts')
<script>
$(document).ready(function () {
  if ($('.carousel-car').length > 0) {
    $('.carousel-car').owlCarousel({
      loop: true,
      autoplay: true,
      autoplayTimeout: 4500,
      autoplayHoverPause: true,
      margin: 20,
      nav: true,
      navText: [
        "<span class='ion-ios-arrow-back'></span>",
        "<span class='ion-ios-arrow-forward'></span>"
      ],
      dots: true,
      touchDrag: true,
      mouseDrag: false,
      pullDrag: true,
      freeDrag: false,
      responsive: {
        0: {
          items: 1,
          mouseDrag: true
        },
        768: {
          items: 2
        },
        1200: {
          items: 3
        }
      }
    });
  }
});
</script>
@endpush
