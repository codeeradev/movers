<section class="ftco-section">
  <div class="container-fluid px-4">
    <div class="row justify-content-center">
      <div class="col-md-12 heading-section text-center ftco-animate mb-5">
        <span class="subheading">Our Process</span>
        <h2 class="mb-2">How We Shift Your Cars</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="carousel-car owl-carousel">

          @foreach($processes as $process)
            <div class="item">
              <div class="car-wrap ftco-animate">

                <div 
                  class="img"
                  style="background-image: url('{{ $process->image 
                    ? asset('uploads/car-process/'.$process->image) 
                    : asset('images/default-car.jpg') }}');">
                </div>

                <div class="text p-4 text-center">
                  <h3>{{ $process->title }}</h3>
                  <p>{{ $process->description }}</p>
                </div>

              </div>
            </div>
          @endforeach

        </div>
      </div>
    </div>
  </div>
</section>
