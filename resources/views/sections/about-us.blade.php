@push('styles')
<style>
    .about-section {
        position: relative;
        padding: 96px 0;
        background:
            radial-gradient(circle at top left, rgba(252, 152, 60, 0.08), transparent 34%),
            linear-gradient(180deg, #ffffff 0%, #fbfcff 100%);
        overflow: hidden;
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

    .about-image-wrap {
        position: relative;
        border-radius: 22px;
        overflow: hidden;
        height: 100%;
        min-height: 420px;
        background: transparent;
        border: none;
        box-shadow: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .about-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
        padding: 0;
    }

    .about-image-wrap::after {
        content: '';
        position: absolute;
        inset: auto 0 0;
        height: 42%;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0), rgba(15, 23, 42, 0.18));
        pointer-events: none;
    }

    .about-no-image {
        width: 100%;
        height: 100%;
        min-height: 420px;
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
        padding: 28px 0 28px 28px;
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
        font-weight: 700;
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
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 20px;
        letter-spacing: -0.03em;
    }

    .about-content .about-desc {
        font-size: 16px;
        color: #475569;
        line-height: 1.9;
        margin-bottom: 28px;
    }

    .about-content .about-desc p {
        margin-bottom: 14px;
    }

    .about-content .about-desc p:last-child {
        margin-bottom: 0;
    }

    .about-values {
        margin-top: 24px;
    }

    .about-values-head {
        margin-bottom: 18px;
    }

    .about-values-head h3 {
        margin: 0 0 8px;
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .about-values-head p {
        margin: 0;
        color: #64748b;
        line-height: 1.8;
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
        font-weight: 700;
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

    .about-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .about-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #fc983c 0%, #e85b2a 100%);
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 14px 26px;
        border-radius: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        align-self: flex-start;
        border: none;
        box-shadow: 0 16px 30px rgba(232, 91, 42, 0.25);
    }

    .about-btn:hover {
        background: linear-gradient(135deg, #e85b2a 0%, #c73516 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(232, 64, 28, 0.25);
        text-decoration: none;
    }

    .about-btn svg {
        width: 16px;
        height: 16px;
        transition: transform 0.3s ease;
    }

    .about-btn:hover svg {
        transform: translateX(3px);
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
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.1);
    }

    @media (max-width: 767px) {
        .about-section {
            padding: 72px 0;
        }

        .about-content {
            padding: 0;
            margin-top: 24px;
        }

        .about-content h2 {
            font-size: 28px;
        }

        .about-image-wrap,
        .about-no-image {
            min-height: 280px;
            border-radius: 22px;
        }

        .about-highlights {
            grid-template-columns: 1fr;
        }

        .about-values-head h3 {
            font-size: 20px;
        }
    }
</style>
@endpush

<section class="about-section ftco-section">
    <div class="container">
        <div class="row align-items-stretch gy-4">

            <div class="col-md-6 ftco-animate">
                <div class="about-image-wrap">
                    @if($about && !empty($about->image) && file_exists(public_path('uploads/about/'.$about->image)))
                    <img
                        src="{{ asset('uploads/about/'.$about->image) }}"
                        alt="{{ $about?->title ?? 'About Us' }}">
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

            <div class="col-md-6 ftco-animate">
                <div class="about-content">
                    <span class="about-kicker">Who We Are</span>

                    <span class="subheading">
                        {{ $about?->subtitle ?? 'About Us' }}
                    </span>

                    <h2>
                        {{ $about?->title ?? 'About Our Company' }}
                    </h2>

                    <div class="about-desc">
                        @if($about && $about->description)
                        {!! $about->description !!}
                        @endif
                    </div>

                    <div class="about-actions">
                        <a href="{{ route('about-us') }}" class="about-btn">
                            Learn More
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12" />
                                <polyline points="12 5 19 12 12 19" />
                            </svg>
                        </a>
                        <a href="{{ route('contact') }}" class="about-btn secondary">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>

        </div>

        @if($about && ($about->vision || $about->mission))
        <div class="about-values">
            <div class="about-values-head">
                <h3>What Guides Us</h3>
                <p>Vision aur mission ko neeche alag section me rakha hai taaki page zyada clean, structured aur professional lage.</p>
            </div>

            <div class="about-highlights">
                @if($about->vision)
                <div class="about-highlight-card">
                    <h5>Our Vision</h5>
                    <p>{{ trim(strip_tags($about->vision)) }}</p>
                </div>
                @endif
                @if($about->mission)
                <div class="about-highlight-card is-accent">
                    <h5>Our Mission</h5>
                    <p>{{ trim(strip_tags($about->mission)) }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>
