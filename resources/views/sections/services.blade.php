@php
$serviceItems = $services ?? collect();
@endphp

@push('styles')
<style>
  .services-section {
    padding: 80px 0;
    background: #f4f6fb;
  }

  .services-section .subheading {
    display: inline-block;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #FC983C;
    margin-bottom: 12px;
    position: relative;
    padding-left: 42px;
  }

  /* .services-section .subheading::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 32px;
    height: 2px;
    background: #FC983C;
    transform: translateY(-50%);
  } */

  .services-section h2 {
    font-size: 36px;
    font-weight: 800;
    color: #1a1a2e;
    line-height: 1.25;
  }

  /* ── Service Card ── */
  .service-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    border: 1.5px solid #eaedf5;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
    transition: all 0.35s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .service-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(232, 64, 28, 0.1);
    border-color: rgba(232, 64, 28, 0.2);
  }

  /* ── Image ── */
  .service-card-image {
    width: 100%;
    height: 220px;
    overflow: hidden;
    background: #f4f6fb;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .service-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
    transition: transform 0.4s ease;
  }

  .service-card:hover .service-card-image img {
    transform: scale(1.04);
  }

  /* No image placeholder */
  .service-no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #fff3f0, #f4f6fb);
  }

  .service-no-image svg {
    width: 56px;
    height: 56px;
    color: #e2e8f0;
  }

  /* ── Body ── */
  .service-card-body {
    padding: 24px 24px 28px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .service-card-body h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 10px;
    line-height: 1.3;
  }

  .service-card-body h3 a {
    color: #1a1a2e;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .service-card-body h3 a:hover {
    color: #FC983C;
  }

  .service-card-body p {
    font-size: 14.5px;
    color: #6b7280;
    line-height: 1.75;
    margin-bottom: 20px;
    flex: 1;
  }

  /* ── Read More ── */
  .service-read-more {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 700;
    color: #FC983C;
    text-decoration: none;
    letter-spacing: 0.3px;
    transition: gap 0.3s ease;
    align-self: flex-start;
  }

  .service-read-more:hover {
    color: #c73516;
    gap: 10px;
    text-decoration: none;
  }

  .service-read-more svg {
    width: 14px;
    height: 14px;
  }

  @media (max-width: 767px) {
    .services-section h2 {
      font-size: 26px;
    }

    .service-card-image {
      height: 180px;
    }

    .service-card-body {
      padding: 20px;
    }
  }
</style>
@endpush

@if($serviceItems->isNotEmpty())
<section class="services-section ftco-section">
  <div class="container">

    <div class="row justify-content-center mb-5">
      <div class="col-md-8 heading-section text-center ftco-animate">
        <span class="subheading">Our Services</span>
        <h2 class="mb-0">What We Offer</h2>
      </div>
    </div>

    <div class="row gy-4">
      @foreach($serviceItems as $service)
      <div class="col-12 col-md-6 col-lg-4 ftco-animate">
        <div class="service-card">

          {{-- Image --}}
          <div class="service-card-image">
            @if(!empty($service->image) && file_exists(public_path('uploads/services/'.$service->image)))
            <img
              src="{{ asset('uploads/services/'.$service->image) }}"
              alt="{{ $service->title }}">
            @else
            <div class="service-no-image">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <circle cx="8.5" cy="8.5" r="1.5" />
                <polyline points="21 15 16 10 5 21" />
              </svg>
            </div>
            @endif
          </div>

          {{-- Body --}}
          <div class="service-card-body">
            <h3>
              <a href="{{ route('services.single', $service->slug) }}">
                {{ $service->title }}
              </a>
            </h3>

            @if(!empty($service->description))
            <p>{!! Str::limit(strip_tags($service->description), 140) !!}</p>
            @endif

            <a href="{{ route('services.single', $service->slug) }}" class="service-read-more">
              Read More
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12" />
                <polyline points="12 5 19 12 12 19" />
              </svg>
            </a>
          </div>

        </div>
      </div>
      @endforeach
    </div>

  </div>
</section>
@endif