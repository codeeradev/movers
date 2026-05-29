@php
    $chooseItems = site_setting('home_choose_items') ?: [
        ['icon' => 'flaticon-search', 'title' => 'Inspection', 'description' => 'Every vehicle undergoes a detailed inspection before pickup and before final delivery to ensure complete safety.'],
        ['icon' => 'flaticon-cash', 'title' => 'Secure Loading', 'description' => 'Vehicles are loaded using professional equipment and secured properly during transportation.'],
        ['icon' => 'flaticon-24-hours', 'title' => 'Live Tracking Support', 'description' => 'Get regular updates and tracking assistance throughout the transportation process.'],
        ['icon' => 'flaticon-fast-delivery', 'title' => 'On-Time Delivery', 'description' => 'We focus on timely pickup and delivery schedules to minimize delays.'],
        ['icon' => 'flaticon-insurance', 'title' => 'Fully Insured Transportation', 'description' => 'Additional protection options available for peace of mind during transit.'],
        ['icon' => 'flaticon-happy', 'title' => 'Customer Satisfaction', 'description' => 'Our support team remains available even after delivery to ensure a smooth experience.'],
    ];
@endphp

<section class="ftco-section">
  <div class="container-fluid px-4">
    <div class="row justify-content-center">
      <div class="col-md-12 heading-section text-center ftco-animate mb-5">
        <span class="subheading">{{ site_setting('home_choose_subtitle', 'Why Choose Us') }}</span>
        <h2 class="mb-2">{{ site_setting('home_choose_title', 'Why Choose Us') }}</h2>
      </div>
    </div>

    <div class="row">
      @foreach($chooseItems as $item)
        <div class="col-md-4 d-flex align-self-stretch ftco-animate mb-4">
          <div class="media block-6 services services-2 w-100">
            <div class="media-body py-md-4">
              <div class="icon mb-3">
                <span class="{{ $item['icon'] ?? 'flaticon-search' }}"></span>
              </div>
              <h3 class="heading">{{ $item['title'] ?? '' }}</h3>
              <p>{{ $item['description'] ?? '' }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
