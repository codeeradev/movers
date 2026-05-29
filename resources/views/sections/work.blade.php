@php
    $workSteps = isset($processes) && count($processes)
        ? $processes
        : collect([
            (object) ['title' => 'Pickup Request', 'description' => 'Aap pickup aur delivery location share karte hain jahan se hum car collect karte hain.', 'image' => null],
            (object) ['title' => 'Booking Confirmation', 'description' => 'Price confirmation ke baad booking finalize hoti hai aur pickup schedule kiya jata hai.', 'image' => null],
            (object) ['title' => 'Safe Transportation', 'description' => 'Aapki car ko secure carrier ke through safely destination city tak le jaya jata hai.', 'image' => null],
            (object) ['title' => 'Doorstep Delivery', 'description' => 'Destination par aapke ghar car safely deliver ki jati hai with complete satisfaction.', 'image' => null],
        ]);
@endphp

<section class="ftco-section services-section img" style="background-image: url('{{ asset('images/bg_2.jpg') }}');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
        <span class="subheading">Work Flow</span>
        <h2 class="mb-3">How We Move Your Car</h2>
      </div>
    </div>

    <div class="row">
      @foreach($workSteps as $step)
      <div class="col-md-3 d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services services-2">
          <div class="media-body py-md-4 text-center">
            <div class="icon d-flex align-items-center justify-content-center">
              <span class="flaticon-route"></span>
            </div>
            <h3>{{ $step->title }}</h3>
            <p>{{ $step->description }}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
