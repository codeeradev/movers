@php
    $about = $about ?? null;
    $isDetailView = (bool) ($isDetailView ?? false);

    $aboutImage = $about && !empty($about->image) && file_exists(public_path('uploads/about/' . $about->image))
        ? asset('uploads/about/' . $about->image)
        : asset('images/about.jpg');

    $storyImageTwo = asset('images/car-8.jpg');
    $storyImageThree = asset('images/car-4.jpg');

    $aboutTitle = $about?->title ?: 'Your Trusted Vehicle Transportation Partner';
    $aboutSubtitle = $about?->subtitle ?: 'Built for safe, on-time, and stress-free relocations across India.';
    $aboutDescription = $about?->description ?: 'We combine route planning, secure loading, transparent communication, and a disciplined operations process so every vehicle reaches its destination safely.';

    $visionText = trim(strip_tags($about?->vision ?? 'We want to set the benchmark for dependable vehicle transportation with a customer-first service experience.'));
    $missionText = trim(strip_tags($about?->mission ?? 'Our mission is to deliver vehicles with care, consistency, and complete visibility from pickup to handover.'));
@endphp

@push('styles')
<style>
    .about-section {
        position: relative;
        padding: 96px 0;
        overflow: hidden;
        background:
            radial-gradient(circle at top left, rgba(252, 152, 60, 0.08), transparent 34%),
            linear-gradient(180deg, #ffffff 0%, #fbfcff 100%);
    }

    .about-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(15, 23, 42, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(15, 23, 42, 0.03) 1px, transparent 1px);
        background-size: 48px 48px;
        mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.18), transparent 72%);
        pointer-events: none;
    }

    .about-section .container {
        position: relative;
        z-index: 1;
    }

    .about-teaser-shell {
        display: grid;
        grid-template-columns: 0.95fr 1.05fr;
        gap: 30px;
        align-items: center;
    }

    .about-image-wrap {
        position: relative;
        border-radius: 28px;
        overflow: hidden;
        min-height: 440px;
        background: linear-gradient(180deg, #07142B, #0D1F45);
        box-shadow: 0 28px 72px rgba(7, 20, 43, 0.18);
    }

    .about-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .about-image-wrap::after {
        content: '';
        position: absolute;
        inset: auto 0 0;
        height: 45%;
        background: linear-gradient(180deg, rgba(7, 20, 43, 0), rgba(7, 20, 43, 0.42));
        pointer-events: none;
    }

    .about-no-image {
        width: 100%;
        height: 100%;
        min-height: 440px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 14px;
        color: #cbd5e1;
    }

    .about-no-image svg {
        width: 72px;
        height: 72px;
        color: #cbd5e1;
    }

    .about-no-image span {
        font-size: 14px;
        color: #94a3b8;
        font-weight: 500;
    }

    .about-content {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }

    .about-kicker {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        width: fit-content;
        padding: 10px 16px;
        margin-bottom: 18px;
        border-radius: 999px;
        background: rgba(252, 152, 60, 0.1);
        color: #c34e10;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .about-kicker::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: #fc983c;
        box-shadow: 0 0 0 6px rgba(252, 152, 60, 0.12);
    }

    .about-content .subheading {
        display: inline-block;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.06em;
        color: #475569;
        margin-bottom: 12px;
    }

    .about-content h2 {
        font-size: clamp(32px, 4vw, 48px);
        font-weight: 900;
        color: #0f172a;
        line-height: 1.05;
        margin-bottom: 18px;
        letter-spacing: -0.04em;
    }

    .about-content .about-desc {
        font-size: 16px;
        color: #475569;
        line-height: 1.9;
        margin-bottom: 26px;
        max-width: 620px;
    }

    .about-content .about-desc p {
        margin-bottom: 14px;
    }

    .about-content .about-desc p:last-child {
        margin-bottom: 0;
    }

    .about-excerpt {
        display: -webkit-box;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .about-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 6px;
        justify-content: flex-start;
    }

    .about-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-width: 170px;
        white-space: nowrap;
        background: linear-gradient(135deg, #fc983c 0%, #e85b2a 100%);
        color: #ffffff;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 0.04em;
        padding: 14px 24px;
        border-radius: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 16px 30px rgba(232, 91, 42, 0.22);
    }

    .about-btn:hover {
        background: linear-gradient(135deg, #e85b2a 0%, #c73516 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 20px 36px rgba(232, 64, 28, 0.24);
        text-decoration: none;
    }

    .about-btn.secondary {
        background: #ffffff;
        color: #0f172a;
        border: 1px solid rgba(148, 163, 184, 0.25);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.06);
    }

    .about-btn.secondary:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    .about-values {
        margin-top: 34px;
    }

    .about-values-head {
        margin-bottom: 18px;
    }

    .about-values-head h3 {
        margin: 0 0 8px;
        font-size: 24px;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.03em;
    }

    .about-values-head p {
        margin: 0;
        color: #64748b;
        line-height: 1.8;
        max-width: 760px;
    }

    .about-highlights {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .about-highlight-card {
        padding: 24px;
        border-radius: 22px;
        background: #ffffff;
        border: 1px solid rgba(148, 163, 184, 0.14);
        box-shadow: 0 18px 42px rgba(15, 23, 42, 0.06);
    }

    .about-highlight-card h5 {
        margin: 0 0 8px;
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
    }

    .about-highlight-card p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.75;
    }

    .about-highlight-card.is-accent {
        background: linear-gradient(180deg, rgba(252, 152, 60, 0.12), rgba(252, 152, 60, 0.05));
        border-color: rgba(252, 152, 60, 0.18);
    }

    /* Detail mode */
    .about-detail-shell {
        display: grid;
        grid-template-columns: 1fr;
        gap: 28px;
        align-items: start;
    }

    .about-detail-visual {
        position: relative;
    }

    .about-detail-main {
        width: 100%;
        min-height: 440px;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 24px 58px rgba(7, 20, 43, 0.16);
        background: linear-gradient(180deg, #09162f, #0f244e);
    }

    .about-detail-main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .about-detail-copy .eyebrow {
        display: inline-flex;
        padding: 10px 14px;
        border-radius: 999px;
        background: rgba(7, 20, 43, 0.06);
        color: #07142B;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
    }

    .about-detail-copy h2 {
        margin: 18px 0 14px;
        color: #07142B;
        font-size: clamp(30px, 4vw, 46px);
        font-weight: 900;
        line-height: 1.06;
        letter-spacing: -0.05em;
    }

    .about-detail-copy p {
        margin: 0;
        color: #4b5d78;
        font-size: 16px;
        line-height: 1.9;
    }

    .about-story-points {
        display: grid;
        gap: 14px;
        margin-top: 24px;
    }

    .about-story-point {
        display: flex;
        gap: 14px;
        padding: 16px 18px;
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid rgba(148, 163, 184, 0.12);
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.04);
    }

    .about-story-point .dot {
        flex: 0 0 auto;
        width: 40px;
        height: 40px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(252, 152, 60, 0.12);
        color: #e85b2a;
        font-weight: 900;
    }

    .about-story-point h4 {
        margin: 0 0 6px;
        color: #07142B;
        font-size: 16px;
        font-weight: 800;
    }

    .about-story-point p {
        margin: 0;
        font-size: 14px;
        line-height: 1.75;
    }

    .about-mini-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 24px;
    }

    .about-mini-stat {
        padding: 18px;
        border-radius: 18px;
        background: linear-gradient(180deg, rgba(7, 20, 43, 0.03), rgba(7, 20, 43, 0.015));
        border: 1px solid rgba(148, 163, 184, 0.12);
    }

    .about-mini-stat strong {
        display: block;
        color: #07142B;
        font-size: 24px;
        font-weight: 900;
        line-height: 1;
    }

    .about-mini-stat span {
        display: block;
        margin-top: 8px;
        color: #64748b;
        font-size: 13px;
    }

    @media (max-width: 991px) {
        .about-teaser-shell,
        .about-detail-shell {
            grid-template-columns: 1fr;
        }

        .about-detail-main {
            min-height: 360px;
        }
    }

    @media (max-width: 767px) {
        .about-section {
            padding: 72px 0;
        }

        .about-content {
            margin-top: 22px;
        }

        .about-content h2 {
            font-size: 28px;
        }

        .about-image-wrap,
        .about-no-image {
            min-height: 300px;
            border-radius: 24px;
        }

        .about-highlights,
        .about-mini-stats {
            grid-template-columns: 1fr;
        }

        .about-values-head h3 {
            font-size: 20px;
        }

        .about-detail-main {
            min-height: 280px;
            border-radius: 24px;
        }
    }
</style>
@endpush

@if($isDetailView)
<section class="about-section ftco-section">
    <div class="container">
        <div class="about-detail-shell">
            <div class="about-detail-visual ftco-animate">
                <div class="about-detail-main">
                    <img src="{{ $aboutImage }}" alt="{{ $aboutTitle }}">
                </div>
            </div>

            <div class="about-detail-copy ftco-animate">
                <span class="eyebrow">Company Story</span>
                <h2>{{ $aboutTitle }}</h2>
                <p>{{ $aboutSubtitle }}</p>

                <div class="about-desc">
                    @if($about && $about->description)
                        {!! $about->description !!}
                    @else
                        <p>We combine route planning, secure loading, transparent communication, and a disciplined operations process so every vehicle reaches its destination safely.</p>
                    @endif
                </div>

                <div class="about-mini-stats">
                    <div class="about-mini-stat">
                        <strong>99%</strong>
                        <span>On-time handovers</span>
                    </div>
                    <div class="about-mini-stat">
                        <strong>25+</strong>
                        <span>Routes and coverage areas</span>
                    </div>
                    <div class="about-mini-stat">
                        <strong>24/7</strong>
                        <span>Support and assistance</span>
                    </div>
                </div>

                <div class="about-actions" style="margin-top:26px;">
                    <a href="{{ route('services') }}" class="about-btn">Explore Services</a>
                    <a href="{{ route('contact') }}" class="about-btn secondary">Talk to Us</a>
                </div>
            </div>
        </div>

        @if($about && ($about->vision || $about->mission))
        <div class="about-values">
            <div class="about-values-head">
                <h3>What Guides Us</h3>
                <p>Our values, vision, and mission are presented here in a clean corporate format so visitors can quickly understand how we work.</p>
            </div>

            <div class="about-highlights">
                @if($about->vision)
                <div class="about-highlight-card">
                    <h5>Our Vision</h5>
                    <p>{{ $visionText }}</p>
                </div>
                @endif
                @if($about->mission)
                <div class="about-highlight-card is-accent">
                    <h5>Our Mission</h5>
                    <p>{{ $missionText }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>
@else
<section class="about-section ftco-section">
    <div class="container">
        <div class="about-teaser-shell">
            <div class="ftco-animate">
                <div class="about-image-wrap">
                    @if($about && !empty($about->image) && file_exists(public_path('uploads/about/' . $about->image)))
                        <img src="{{ asset('uploads/about/' . $about->image) }}" alt="{{ $about?->title ?? 'About Us' }}">
                    @else
                        <div class="about-no-image">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            <span>No image available</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="ftco-animate">
                <div class="about-content">
                    <span class="about-kicker">Who We Are</span>
                    <span class="subheading">{{ $about?->subtitle ?? 'About Us' }}</span>
                    <h2>{{ $about?->title ?? 'About Our Company' }}</h2>

                    <div class="about-desc about-excerpt">
                        @if($about && $about->description)
                            {!! $about->description !!}
                        @endif
                    </div>

                    <div class="about-actions">
                        <a href="{{ route('about-us') }}" class="about-btn">
                            Read More
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
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
@endif
