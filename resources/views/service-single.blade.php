@extends('layouts.app')

@section('title', $service->title)

@section('content')
<section class="hero-wrap hero-wrap-2" style="background-image: url('{{ $service->image ? asset('uploads/services/'.$service->image) : asset('images/bg_2.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <h1 class="mb-3 bread">{{ $service->title }}</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ftco-animate">
                @if($service->image)
                    <p>
                        <img src="{{ asset('uploads/services/'.$service->image) }}" alt="{{ $service->title }}" class="img-fluid rounded">
                    </p>
                @endif

                <div class="service-content">
                    {!! $service->description !!}
                </div>
            </div>

            <div class="col-lg-4 sidebar ftco-animate">
                <div class="sidebar-box">
                    <h3 class="heading-sidebar">Recent Services</h3>
                    @foreach($recentServices as $recent)
                        <div class="block-21 mb-4 d-flex">
                            <a href="{{ route('services.single', $recent->slug) }}" class="blog-img mr-4" style="background-image: url('{{ $recent->image ? asset('uploads/services/'.$recent->image) : asset('images/bg_1.jpg') }}');"></a>
                            <div class="text">
                                <h3 class="heading"><a href="{{ route('services.single', $recent->slug) }}">{{ $recent->title }}</a></h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
