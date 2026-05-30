@push('styles')
<style>
  .testimony-section {
    padding: 80px 0;
    background: #f4f6fb;
  }

  .testimony-section .subheading {
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

  /* .testimony-section .subheading::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 32px;
    height: 2px;
    background: #FC983C;
    transform: translateY(-50%);
  } */

  .testimony-section h2 {
    font-size: 36px;
    font-weight: 800;
    color: #1a1a2e;
    line-height: 1.25;
  }

  /* ── Card ── */
  .testimony-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 28px 24px;
    border: 1.5px solid #eaedf5;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 14px;
    transition: all 0.35s ease;
    margin: 6px;
  }

  .testimony-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(232, 64, 28, 0.1);
    border-color: rgba(232, 64, 28, 0.2);
  }

  /* ── Avatar ── */
  .testimony-avatar-wrap {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    border: 3px solid #f0f2f5;
    background: linear-gradient(135deg, #fff3f0, #ffe8e2);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .testimony-avatar-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    display: block;
    border-radius: 0;
  }

  .testimony-avatar-wrap svg {
    width: 40px;
    height: 40px;
    color: #FC983C;
  }

  /* ── Review text ── */
  .testimony-review {
    font-size: 14.5px;
    color: #6b7280;
    line-height: 1.75;
    margin: 0;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
  }

  /* ── Name ── */
  .testimony-name {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
  }

  /* ── Divider ── */
  .testimony-divider {
    width: 40px;
    height: 2px;
    background: #FC983C;
    border-radius: 2px;
    opacity: 0.4;
  }
</style>
@endpush

@if($testimonials->isNotEmpty())
<section class="testimony-section ftco-section">
  <div class="container">

    <div class="row justify-content-center mb-5">
      <div class="col-md-8 text-center heading-section ftco-animate">
        <span class="subheading">Testimonial</span>
        <h2 class="mb-0">Happy Clients</h2>
      </div>
    </div>

    <div class="row ftco-animate">
      <div class="col-md-12">
        <div class="carousel-testimony owl-carousel ftco-owl">
          @foreach($testimonials as $testimonial)
          <div class="item">
            <div class="testimony-card">

              {{-- Avatar --}}
              <div class="testimony-avatar-wrap">
                @if(!empty($testimonial->image) && file_exists(public_path('uploads/testimonials/'.$testimonial->image)))
                <img
                  src="{{ asset('uploads/testimonials/'.$testimonial->image) }}"
                  alt="{{ $testimonial->name }}">
                @else
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" />
                </svg>
                @endif
              </div>

              {{-- Name --}}
              <p class="testimony-name">{{ $testimonial->name }}</p>

              {{-- Divider --}}
              <div class="testimony-divider"></div>

              {{-- Review --}}
              @if(!empty($testimonial->message))
              <p class="testimony-review">"{{ $testimonial->message }}"</p>
              @endif

            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

  </div>
</section>
@endif