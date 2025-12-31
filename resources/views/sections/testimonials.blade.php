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
@push('styles')
<style>/* Happy Clients – same size testimonial cards */
.testimony-wrap {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 420px;   /* 🔥 same height for all boxes */
    height: 100%;
    padding: 30px 20px;
    background: #fff;
}

/* Text area grows equally */
.testimony-wrap .text {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Message limit (optional but recommended) */
.testimony-wrap .text p.mb-4 {
    flex: 1;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 4;   /* max 4 lines */
    -webkit-box-orient: vertical;
}

/* Image same size */
.testimony-wrap .user-img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    margin: 0 auto;
}

</style>
@endpush
