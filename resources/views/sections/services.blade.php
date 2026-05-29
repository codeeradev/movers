@php
    $serviceItems = site_setting('home_services_items') ?: [
        ['icon' => 'flaticon-route', 'title' => 'Door-to-Door Car Transport', 'description' => 'Safe pickup and delivery of vehicles from your location to the destination.'],
        ['icon' => 'flaticon-rent', 'title' => 'Interstate Vehicle Transportation', 'description' => 'Reliable vehicle shifting between states across India.'],
        ['icon' => 'flaticon-online-booking', 'title' => 'Open Car Carrier Service', 'description' => 'Cost-effective transportation through professional open carriers.'],
        ['icon' => 'flaticon-customer-support', 'title' => 'Dedicated Cargo Vehicle Service', 'description' => 'Dedicated transport solutions for urgent vehicle deliveries.'],
        ['icon' => 'flaticon-customer-support', 'title' => 'Commercial Vehicle Transportation', 'description' => 'Transportation support for business and fleet vehicles.'],
        ['icon' => 'flaticon-online-booking', 'title' => 'Logistics & Cargo Solutions', 'description' => 'Efficient cargo movement services for businesses and individuals.'],
    ];
@endphp

<section class="ftco-section services-section ftco-no-pt ftco-no-pb">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 heading-section text-center ftco-animate mb-5">
        <span class="subheading">{{ site_setting('home_services_subtitle', 'Our Services') }}</span>
        <h2 class="mb-2">{{ site_setting('home_services_title', 'What We Offer') }}</h2>
      </div>
    </div>

    <div class="row d-flex">
      @foreach($serviceItems as $service)
        <div class="col-md-4 d-flex align-self-stretch ftco-animate mb-4">
          <div class="media block-6 services w-100">
            <div class="media-body py-md-4">
              <div class="d-flex mb-3 align-items-center">
                <div class="icon"><span class="{{ $service['icon'] ?? 'flaticon-route' }}"></span></div>
                <h3 class="heading mb-0 pl-3">{{ $service['title'] ?? '' }}</h3>
              </div>
              <p>{{ $service['description'] ?? '' }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
