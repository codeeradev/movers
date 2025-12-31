<section class="ftco-section testimony-section">
  <div class="container">

    <!-- Heading -->
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 text-center heading-section ftco-animate">
        <span class="subheading">Testimonial</span>
        <h2 class="mb-3">Happy Clients</h2>
      </div>
    </div>

    <div class="row ftco-animate">
      <div class="col-md-12">
        <div class="carousel-testimony owl-carousel ftco-owl">

          @forelse($testimonials as $testimonial)
          <div class="item">
            <div class="testimony-wrap text-center py-4 pb-5">

              <!-- Client Image -->
              <div class="user-img mb-4"
                   style="background-image: url('{{ asset('uploads/testimonials/'.$testimonial->image) }}')">
              </div>

              <div class="text pt-4">
                <p class="mb-4">
                  {{ $testimonial->message }}
                </p>
                <p class="name">
                  {{ $testimonial->name }}
                </p>
                <span class="position">
                  {{ $testimonial->designation }}
                </span>
              </div>

            </div>
          </div>
          @empty
            <div class="item">
              <div class="testimony-wrap text-center py-4 pb-5">
                <div class="text pt-4">
                  <p class="mb-4">No testimonials available.</p>
                </div>
              </div>
            </div>
          @endforelse

        </div>
      </div>
    </div>

  </div>
</section>
