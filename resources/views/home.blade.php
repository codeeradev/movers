@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('sections.hero-wrap')

   @include('sections.search')
   @include('sections.services')


 @include('sections.choose')

     @include('sections.work')
 @include('sections.testimonials')

 @include('sections.about-us')
	 @include('sections.blog')	

   


@endsection
@push('scripts')
<script>
$(document).ready(function () {
  if ($('.carousel-car').length > 0) {
    $('.carousel-car').owlCarousel({
      loop: true,

      /* 🔁 AUTOPLAY */
      autoplay: true,
      autoplayTimeout: 4500,   // slow autoplay (increase = slower)
      autoplayHoverPause: true,

      /* 📐 LAYOUT */
      margin: 20,

      /* ⬅️➡️ ARROWS */
      nav: true,
      navText: [
        "<span class='ion-ios-arrow-back'></span>",
        "<span class='ion-ios-arrow-forward'></span>"
      ],

      /* 🔘 DOTS */
      dots: true,

      /* 📱 MOBILE OPTIMIZATION */
      touchDrag: true,
      mouseDrag: false,  // desktop pe mouse drag off (clean UX)
      pullDrag: true,
      freeDrag: false,

      /* 📏 RESPONSIVE */
      responsive: {
        0: {
          items: 1,
          mouseDrag: true   // mobile swipe ON
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
