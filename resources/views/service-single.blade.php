@extends('layouts.app')

@section('title', $service->title)

@push('styles')
<style>
    /* ── Fix navbar on light header pages ── */
    /* Forces navbar links/logo to dark when over this light header */
    .light-page-header~* .navbar,
    body.light-header .navbar {
        background: #ffffff !important;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
    }

    /* Simpler approach: target navbar directly on this page */
    .ftco-navbar-light.scrolled,
    .ftco-navbar-light {
        background: #ffffff !important;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06) !important;
    }

    .ftco-navbar-light .navbar-nav .nav-link {
        color: #1a1a2e !important;
    }

    .ftco-navbar-light .navbar-nav .nav-link:hover,
    .ftco-navbar-light .navbar-nav .active>.nav-link {
        color: #e8401c !important;
    }

    .ftco-navbar-light .navbar-brand {
        color: #1a1a2e !important;
    }

    /* ── Page Header ── */
    .service-page-header {
        background: #f4f6fb;
        padding-top: 120px;
        /* pushes content below fixed navbar */
        padding-bottom: 50px;
        position: relative;
        overflow: hidden;
        border-bottom: 1.5px solid #eaedf5;
    }

    .service-page-header::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(232, 64, 28, 0.06);
        pointer-events: none;
    }

    .service-page-header::after {
        content: '';
        position: absolute;
        bottom: -60px;
        left: -40px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(232, 64, 28, 0.04);
        pointer-events: none;
    }

    .service-page-header .breadcrumb-wrap {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 16px;
    }

    .service-page-header .breadcrumb-wrap a {
        font-size: 13px;
        color: #9ca3af;
        text-decoration: none;
        transition: color 0.2s;
    }

    .service-page-header .breadcrumb-wrap a:hover {
        color: #e8401c;
    }

    .service-page-header .breadcrumb-wrap .sep {
        font-size: 13px;
        color: #d1d5db;
    }

    .service-page-header .breadcrumb-wrap .current {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    .service-page-header .header-tag {
        display: inline-block;
        background: rgba(232, 64, 28, 0.08);
        border: 1px solid rgba(232, 64, 28, 0.2);
        color: #e8401c;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 5px 14px;
        border-radius: 20px;
        margin-bottom: 16px;
    }

    .service-page-header h1 {
        font-size: 40px;
        font-weight: 900;
        color: #1a1a2e;
        line-height: 1.2;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 767px) {
        .service-page-header {
            padding-top: 100px;
            padding-bottom: 32px;
        }

        .service-page-header h1 {
            font-size: 26px;
        }
    }

    /* ── Main Content ── */
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

    .sidebar-card-header h3::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 16px;
        background: #e8401c;
        border-radius: 2px;
    }

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
        color: #e8401c;
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

    /* CTA Box */
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
        background: #e8401c;
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

@section('content')

{{-- ── Page Header ── --}}
<div class="service-page-header">
    <div class="container">
        <div class="breadcrumb-wrap">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <a href="{{ route('services') }}">Services</a>
            <span class="sep">/</span>
            <span class="current">{{ $service->title }}</span>
        </div>
        <span class="header-tag">Our Services</span>
        <h1>{{ $service->title }}</h1>
    </div>
</div>

{{-- ── Main Section ── --}}
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