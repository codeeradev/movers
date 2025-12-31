<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container">
        <div class="row no-gutters">

            <!-- Image -->
            <div
                class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center"
                style="background-image: url('{{ $about && $about->image
                    ? asset('uploads/about/'.$about->image)
                    : asset('images/about.jpg') }}');">
            </div>

            <!-- Content -->
            <div class="col-md-6 wrap-about py-md-5 ftco-animate">
                <div class="heading-section mb-5 pl-md-5">

                    <span class="subheading">
                        {{ $about->subtitle ?? 'About Us' }}
                    </span>

                    <h2 class="mb-4">
                        {{ $about->title ?? 'About Our Company' }}
                    </h2>

                    @if($about && $about->description)
                        {!! $about->description !!}
                    @else
                        <p>
                            We provide reliable door-to-door car transportation
                            services with complete safety and transparency.
                        </p>
                    @endif

                    <p>
                        <a href="" class="btn btn-primary">
                            Search Vehicle
                        </a>
                    </p>

                </div>
            </div>

        </div>
    </div>
</section>
