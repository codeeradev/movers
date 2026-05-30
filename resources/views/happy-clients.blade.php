@extends('layouts.app')
@section('title', 'Happy Clients')
@section('content')
@php
$heroBackground = site_setting('hero_background_image')
? asset('uploads/settings/' . site_setting('hero_background_image'))
: asset('images/bg_1.jpg');
@endphp

<section class="hero-wrap hero-wrap-2" style="background-image: url('{{ $heroBackground }}');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text align-items-end justify-content-start">
      <div class="col-md-9 ftco-animate pb-5">
        <p class="breadcrumbs">
          <span class="mr-2">
            <a href="{{ url('/') }}">Home <i class="ion-ios-arrow-forward"></i></a>
          </span>
          <span class="mr-2">
            <a href="{{ route('services') }}">Happy Clients <i class="ion-ios-arrow-forward"></i></a>
          </span>
        </p>
      </div>
    </div>
  </div>
</section>
@push('styles')
<style>
  .slider-text .bread:after {
    display: none !important;
    content: none !important;
  }

  .slider-text .bread {
    padding-left: 0;
  }

  .hero-wrap.hero-wrap-2,
  .hero-wrap.hero-wrap-2 .slider-text {
    height: 400px !important;
  }
</style>
@endpush
@include('sections.testimonials')
@endsection