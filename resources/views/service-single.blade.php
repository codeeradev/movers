@extends('layouts.app')

@section('title', $service->title)

@section('content')

{{-- ── Page Header ── --}}
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
                        <a href="{{ route('services') }}">Services <i class="ion-ios-arrow-forward"></i></a>
                    </span>
                    <span>{{ $service->title }}</span>
                </p>
                <h1 class="mb-3 bread">{{ $service->title }}</h1>
            </div>
        </div>
    </div>
</section>

{{-- ── Main Section ── --}}
@push('styles')
<style>
    .hero-wrap.hero-wrap-2, .hero-wrap.hero-wrap-2 .slider-text {
        height: 400px !important;
    }

    .service-detail-section {
        padding: 70px 0;
        background: #ffffff;
    }

    .service-detail-image {
        width: 100%;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 36px;
        border: 1.5px solid #eaedf5;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
    }

    .service-detail-image img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
    }

    .service-content-body {
        font-size: 15.5px;
        color: #4b5563;
        line-height: 1.85;
    }

    .service-content-body h1,
    .service-content-body h2,
    .service-content-body h3,
    .service-content-body h4 {
        color: #1a1a2e;
        font-weight: 700;
        margin-top: 28px;
        margin-bottom: 12px;
    }

    .service-content-body p {
        margin-bottom: 16px;
    }

    .service-content-body ul,
    .service-content-body ol {
        padding-left: 20px;
        margin-bottom: 16px;
    }

    .service-content-body li {
        margin-bottom: 8px;
    }

    .service-content-body img {
        max-width: 100%;
        border-radius: 10px;
        margin: 16px 0;
    }

    /* ── Sidebar ── */
    .service-sidebar {
        position: sticky;
        top: 100px;
    }

    .sidebar-card {
        background: #f8f9fc;
        border-radius: 16px;
        border: 1.5px solid #eaedf5;
        overflow: hidden;
        margin-bottom: 28px;
    }

    .sidebar-card-header {
        padding: 18px 24px;
        border-bottom: 1.5px solid #eaedf5;
        background: #ffffff;
    }

    .sidebar-card-header h3 {
        font-size: 16px;
        font-weight: 800;
        color: #1a1a2e;
        margin: 0;
        position: relative;
        padding-left: 14px;
    }

    /* .sidebar-card-header h3::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 16px;
        background: #FC983C;
        border-radius: 2px;
    } */

    .sidebar-card-body {
        padding: 20px 24px;
    }

    .recent-service-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #eaedf5;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .recent-service-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .recent-service-item:first-child {
        padding-top: 0;
    }

    .recent-service-item:hover {
        text-decoration: none;
    }

    .recent-service-item:hover .recent-service-title {
        color: #FC983C;
    }

    .recent-service-thumb {
        width: 58px;
        height: 58px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        background: linear-gradient(135deg, #fff3f0, #f4f6fb);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #eaedf5;
    }

    .recent-service-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .recent-service-thumb svg {
        width: 24px;
        height: 24px;
        color: #e2e8f0;
    }

    .recent-service-title {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a2e;
        line-height: 1.4;
        transition: color 0.25s ease;
    }

    .sidebar-cta {
        background: linear-gradient(135deg, #fff3f0, #fff8f6);
        border-radius: 16px;
        padding: 32px 24px;
        text-align: center;
        border: 1.5px solid rgba(232, 64, 28, 0.15);
    }

    .sidebar-cta h4 {
        font-size: 18px;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 10px;
    }

    .sidebar-cta p {
        font-size: 13.5px;
        color: #6b7280;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .sidebar-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #FC983C;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        width: 100%;
        justify-content: center;
    }

    .sidebar-cta-btn:hover {
        background: #c73516;
        color: #ffffff;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(232, 64, 28, 0.25);
    }
</style>
@endpush

<section class="service-detail-section">
    <div class="container">
        <div class="row gy-5">

            <div class="col-lg-8 ftco-animate">
                @if(!empty($service->image) && file_exists(public_path('uploads/services/'.$service->image)))
                <div class="service-detail-image">
                    <img src="{{ asset('uploads/services/'.$service->image) }}" alt="{{ $service->title }}">
                </div>
                @endif

                @if(!empty($service->description))
                <div class="service-content-body">
                    {!! $service->description !!}
                </div>
                @endif
            </div>

            <div class="col-lg-4 ftco-animate">
                <div class="service-sidebar">

                    @if(!empty($recentServices) && $recentServices->isNotEmpty())
                    <div class="sidebar-card">
                        <div class="sidebar-card-header">
                            <h3>Recent Services</h3>
                        </div>
                        <div class="sidebar-card-body">
                            @foreach($recentServices as $recent)
                            <a href="{{ route('services.single', $recent->slug) }}" class="recent-service-item">
                                <div class="recent-service-thumb">
                                    @if(!empty($recent->image) && file_exists(public_path('uploads/services/'.$recent->image)))
                                    <img src="{{ asset('uploads/services/'.$recent->image) }}" alt="{{ $recent->title }}">
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <polyline points="21 15 16 10 5 21" />
                                    </svg>
                                    @endif
                                </div>
                                <span class="recent-service-title">{{ $recent->title }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="sidebar-cta">
                        <h4>Need This Service?</h4>
                        <p>Get in touch with us today and we'll help you with the best solution.</p>
                        <a href="{{ url('/contact') }}" class="sidebar-cta-btn">
                            Contact Us
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                                <line x1="5" y1="12" x2="19" y2="12" />
                                <polyline points="12 5 19 12 12 19" />
                            </svg>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection