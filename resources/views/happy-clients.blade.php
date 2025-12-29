@extends('layouts.app')

@section('title', 'happy-clients.')

@section('content')


  <!-- HERO -->
  <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_2.jpg');">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text js-fullheight align-items-end">
        <div class="col-md-9 ftco-animate pb-5">
          <p class="breadcrumbs">
            <span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span>
            <span>Happy Clients <i class="ion-ios-arrow-forward"></i></span>
          </p>
          <h1 class="mb-3 bread">Happy Clients</h1>
        </div>
      </div>
    </div>
  </section>

 @include('sections.testimonials')



@endsection
