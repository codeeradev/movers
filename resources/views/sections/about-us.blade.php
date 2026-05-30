@push('styles')
<style>
    .about-section {
        padding: 80px 0;
        background: #ffffff;
    }

    /* ── Image Side ── */
    .about-image-wrap {
        border-radius: 16px;
        overflow: hidden;
        height: 100%;
        min-height: 420px;
        background: #f4f6fb;
        border: 1.5px solid #eaedf5;
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
    }

    /* No image placeholder */
    .about-no-image {
        width: 100%;
        height: 100%;
        min-height: 420px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        color: #d1d5db;
    }

    .about-no-image svg {
        width: 80px;
        height: 80px;
        color: #e2e8f0;
    }

    .about-no-image span {
        font-size: 14px;
        color: #d1d5db;
        font-weight: 500;
    }

    /* ── Content Side ── */
    .about-content {
        padding: 40px 48px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }

    .about-content .subheading {
        display: inline-block;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: #FC983C;
        margin-bottom: 14px;
        position: relative;
        padding-left: 42px;
    }

    /* .about-content .subheading::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 32px;
        height: 2px;
        background: #FC983C;
        transform: translateY(-50%);
    } */

    .about-content h2 {
        font-size: 34px;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1.25;
        margin-bottom: 20px;
    }

    .about-content .about-desc {
        font-size: 15px;
        color: #6b7280;
        line-height: 1.8;
        margin-bottom: 32px;
    }

    .about-content .about-desc p {
        margin-bottom: 12px;
    }

    .about-content .about-desc p:last-child {
        margin-bottom: 0;
    }

    .about-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #FC983C;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 13px 28px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        align-self: flex-start;
        border: none;
    }

    .about-btn:hover {
        background: #c73516;
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

    @media (max-width: 767px) {
        .about-content {
            padding: 32px 20px;
        }

        .about-content h2 {
            font-size: 26px;
        }

        .about-image-wrap,
        .about-no-image {
            min-height: 280px;
        }
    }
</style>
@endpush

<section class="about-section ftco-section">
    <div class="container">
        <div class="row align-items-stretch gy-4">

            {{-- Image Side --}}
            <div class="col-md-6 ftco-animate">
                <div class="about-image-wrap">
                    @if($about && !empty($about->image) && file_exists(public_path('uploads/about/'.$about->image)))
                    <img
                        src="{{ asset('uploads/about/'.$about->image) }}"
                        alt="{{ $about->title ?? 'About Us' }}">
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

            {{-- Content Side --}}
            <div class="col-md-6 ftco-animate">
                <div class="about-content">

                    <span class="subheading">
                        {{ $about->subtitle ?? 'About Us' }}
                    </span>

                    <h2>
                        {{ $about->title ?? 'About Our Company' }}
                    </h2>

                    <div class="about-desc">
                        @if($about && $about->description)
                        {!! $about->description !!}
                        @endif
                    </div>

                    <a href="" class="about-btn">
                        Search Vehicle
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>

                </div>
            </div>

        </div>
    </div>
</section>