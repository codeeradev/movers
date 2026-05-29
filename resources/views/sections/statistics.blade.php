@php
    $statItems = site_setting('home_stats_items') ?: [
        ['value' => '5000+', 'label' => 'Vehicles Delivered'],
        ['value' => '1000+', 'label' => 'Happy Customers'],
        ['value' => '25+', 'label' => 'States Covered'],
        ['value' => '99%', 'label' => 'Customer Satisfaction'],
    ];
@endphp

<section class="ftco-counter img" id="section-counter" style="background-image: url('{{ asset('images/bg_2.jpg') }}');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 heading-section heading-section-white text-center ftco-animate">
        <span class="subheading">{{ site_setting('home_stats_subtitle', 'Statistics') }}</span>
        <h2>{{ site_setting('home_stats_title', 'Our Numbers') }}</h2>
      </div>
    </div>
    <div class="row">
      @foreach($statItems as $item)
        <div class="col-md-3 justify-content-center counter-wrap ftco-animate">
          <div class="block-18 text-center">
            <div class="text">
              <strong class="number">{{ $item['value'] ?? '' }}</strong>
              <span>{{ $item['label'] ?? '' }}</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
