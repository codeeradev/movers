@extends('layouts.app')

@section('title', 'Services')

@section('content')
<section class="hero-wrap hero-wrap-2" style="background-image: url('{{ asset('images/bg_2.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <h1 class="mb-3 bread">Our Services</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            @forelse($services as $service)
                <div class="col-md-4 d-flex ftco-animate mb-4">
                    <div class="blog-entry justify-content-end w-100">
                        <a href="{{ route('services.single', $service->slug) }}"
                           class="block-20"
                           style="background-image: url('{{ $service->image ? asset('uploads/services/'.$service->image) : asset('images/bg_1.jpg') }}');">
                        </a>
                        <div class="text pt-4">
                            <h3 class="heading">
                                <a href="{{ route('services.single', $service->slug) }}">{{ $service->title }}</a>
                            </h3>
                            <p>{!! Str::limit(strip_tags($service->description), 160) !!}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No services available yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
