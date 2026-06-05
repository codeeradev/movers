@extends('layouts.app')
@section('title', $about?->title ?: 'About Us')
@section('content')

@php
    $aboutTitle = $about?->title ?: 'About Us';
    $aboutSubtitle = $about?->subtitle ?: 'Company profile';
    $aboutLead = $about?->description
        ? trim(strip_tags($about->description))
        : 'Learn more about our story, our values, and the standards we keep for every move.';

    $heroBackground = site_setting('hero_background_image')
        ? asset('uploads/settings/' . site_setting('hero_background_image'))
        : asset('images/bg_1.jpg');
@endphp

<section class="hero-wrap hero-wrap-2 about-hero" style="background-image: url('{{ $heroBackground }}');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text align-items-end justify-content-start">
      <div class="col-md-9 ftco-animate pb-5">
        <p class="breadcrumbs">
          <span class="mr-2">
            <a href="{{ url('/') }}">Home <i class="ion-ios-arrow-forward"></i></a>
          </span>
          <span class="mr-2">
            <a href="{{ route('about-us') }}">About Us <i class="ion-ios-arrow-forward"></i></a>
          </span>
        </p>
        
      </div>
    </div>
  </div>
</section>

@push('styles')
<style>
  .about-hero.hero-wrap.hero-wrap-2,
  .about-hero.hero-wrap.hero-wrap-2 .slider-text {
    min-height: 380px;
    height: 380px !important;
  }

  .about-hero .overlay {
    background: linear-gradient(90deg, rgba(15, 23, 42, 0.72), rgba(15, 23, 42, 0.42));
  }

  .about-hero .slider-text {
    position: relative;
  }

  .about-hero .breadcrumbs {
    margin-bottom: 12px;
  }

  .about-hero .bread {
    padding-left: 0;
    position: relative;
  }

  .about-hero .bread:after {
    display: none !important;
    content: none !important;
  }

  .about-page-tag {
    display: inline-flex;
    align-items: center;
    width: fit-content;
    margin-bottom: 14px;
    padding: 10px 16px;
    border-radius: 999px;
    background: rgba(252, 152, 60, 0.16);
    color: #fff7ed;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
  }

  .about-page-lead {
    max-width: 560px;
    margin: 0;
    color: rgba(255, 255, 255, 0.88);
    font-size: 16px;
    line-height: 1.8;
  }

  @media (max-width: 767px) {
    .about-hero.hero-wrap.hero-wrap-2,
    .about-hero.hero-wrap.hero-wrap-2 .slider-text {
      height: 320px !important;
      min-height: 320px;
    }

    .about-page-lead {
      font-size: 15px;
    }
  }
</style>
@endpush

@include('sections.about-us', ['isDetailView' => true])

@endsection
