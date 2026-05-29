@php
    $serviceItems = $services ?? collect();
@endphp

<section class="ftco-section services-section ftco-no-pt ftco-no-pb">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 heading-section text-center ftco-animate mb-5">
        <span class="subheading">Our Services</span>
        <h2 class="mb-2">What We Offer</h2>
      </div>
    </div>

    <div class="row d-flex">
      @forelse($serviceItems as $service)
        <div class="col-md-4 d-flex align-self-stretch ftco-animate mb-4">
          <div class="media block-6 services w-100">
            @if($service->image)
              <div class="service-image mb-3">
                <img src="{{ asset('uploads/services/'.$service->image) }}" alt="{{ $service->title }}" class="img-fluid rounded w-100">
              </div>
            @endif

            <div class="media-body py-md-3">
              <h3 class="heading mb-3">
                <a href="{{ route('services.single', $service->slug) }}" class="text-dark">
                  {{ $service->title }}
                </a>
              </h3>
              <p>{!! Str::limit(strip_tags($service->description), 140) !!}</p>
              <a href="{{ route('services.single', $service->slug) }}" class="btn btn-sm btn-outline-primary mt-2">
                Read More
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center">
          <p>No services available yet.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>

@push('styles')
<style>
  .service-image img {
    height: 220px;
    object-fit: cover;
  }
</style>
@endpush
