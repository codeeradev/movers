<footer class="ftco-footer ftco-bg-dark ftco-section" style="padding: 40px;">
  <div class="container">
    <div class="row mb-5">

      <!-- ABOUT -->
      <div class="col-md-3">
        <div class="ftco-footer-widget mb-4">

          {{-- Logo --}}
          @php $logoPath = site_setting('logo'); @endphp
          @if($logoPath && file_exists(public_path('uploads/settings/' . $logoPath)))
          <a href="{{ url('/') }}" class="d-inline-block mb-3">
            <img
              src="{{ asset('uploads/settings/' . $logoPath) }}"
              alt="{{ site_setting('site_name', 'Laxis Cargo Movers') }}"
              style="max-height: 60px; width: auto;">
          </a>
          @else
          <h2 class="ftco-heading-2">
            <a href="{{ url('/') }}" style="color:inherit; text-decoration:none;">
              {{ site_setting('site_name', 'Laxis Cargo Movers') }}
            </a>
          </h2>
          @endif

          <p>
            Trusted door-to-door vehicle transportation across India.
            Safe, reliable, and on-time delivery — your vehicle, our responsibility.
          </p>
          <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-4">
            <li class="ftco-animate">
              <a href="https://www.facebook.com/LaxisCargo" target="_blank" rel="noopener">
                <span class="icon-facebook"></span>
              </a>
            </li>
            <li class="ftco-animate">
              <a href="https://www.instagram.com/laxiscargo/" target="_blank" rel="noopener">
                <span class="icon-instagram"></span>
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- COMPANY -->
      <div class="col-md-2">
        <div class="ftco-footer-widget mb-4 ml-md-3">
          <h2 class="ftco-heading-2">Company</h2>
          <ul class="list-unstyled">
            <li><a href="{{ url('/about') }}" class="py-2 d-block">About Us</a></li>
            <li><a href="{{ route('services') }}" class="py-2 d-block">Services</a></li>
            <li><a href="{{ url('/blog') }}" class="py-2 d-block">Blog</a></li>
            <li><a href="{{ url('/terms') }}" class="py-2 d-block">Terms &amp; Conditions</a></li>
            <li><a href="{{ url('/privacy') }}" class="py-2 d-block">Privacy Policy</a></li>
          </ul>
        </div>
      </div>

      <!-- SERVICES — dynamic 4 from DB -->
      <div class="col-md-3">
        <div class="ftco-footer-widget mb-4">
          <h2 class="ftco-heading-2">Services</h2>
          <ul class="list-unstyled">
            @php
            $footerServices = \App\Models\Service::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
            @endphp
            @forelse($footerServices as $fs)
            <li>
              <a href="{{ route('services.single', $fs->slug) }}" class="py-2 d-block">
                {{ $fs->title }}
              </a>
            </li>
            @empty
            <li><a href="{{ route('services') }}" class="py-2 d-block">View All Services</a></li>
            @endforelse
            <li>
              <a href="{{ route('services') }}" class="py-2 d-block" style="color:#e8401c; font-weight:600;">
                View All &rarr;
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- CONTACT -->
      <div class="col-md-4">
        <div class="ftco-footer-widget mb-4">
          <h2 class="ftco-heading-2">Contact Us</h2>
          <div class="block-23 mb-3">
            <ul>
              <li>
                <span class="icon icon-map-marker"></span>
                <span class="text">
                  House No. 164, 18th Cross B, Hoysala Nagar,
                  Ramamurthy Nagar, Bengaluru – 560016
                </span>
              </li>
              <li>
                <a href="tel:+919731166449">
                  <span class="icon icon-phone"></span>
                  <span class="text">+91 97311 66449</span>
                </a>
              </li>
              <li>
                <a href="tel:+917899418883">
                  <span class="icon icon-phone"></span>
                  <span class="text">+91 78994 18883</span>
                </a>
              </li>
              <li>
                <a href="mailto:laxiscargomovers@gmail.com">
                  <span class="icon icon-envelope"></span>
                  <span class="text">laxiscargomovers@gmail.com</span>
                </a>
              </li>
              <li>
                <span class="icon icon-clock-o"></span>
                <span class="text">Office Hours: 9:00 AM – 9:00 PM</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>

    <!-- COPYRIGHT -->
    <div class="row">
      <div class="col-md-12 text-center">
        <p class="mb-0">
          &copy; {{ date('Y') }} Laxis Cargo Movers. All Rights Reserved.
        </p>
      </div>
    </div>

  </div>
</footer>

<!-- Loader -->
<div id="ftco-loader" class="show fullscreen">
  <svg class="circular" width="48px" height="48px">
    <circle class="path-bg" cx="24" cy="24" r="22"
      fill="none" stroke-width="4" stroke="#eeeeee" />
    <circle class="path" cx="24" cy="24" r="22"
      fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
  </svg>
</div>