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
