@php
$heroBackground = site_setting('hero_background_image')
? asset('uploads/settings/' . site_setting('hero_background_image'))
: asset('images/bg_1.jpg');
@endphp

<div class="hero-wrap hero-home" style="background-image: url('{{ $heroBackground }}');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>

    <div class="container">
        <div class="row no-gutters slider-text hero-home-row align-items-center">
            <div class="col-lg-7 col-md-12 ftco-animate d-flex align-items-center hero-copy-col">
                <div class="text hero-copy">
                    @if(site_setting('hero_subtitle'))
                        <div class="hero-kicker mb-2">
                            {{ site_setting('hero_subtitle') }}
                        </div>
                    @endif
                    <h1 class="mb-4 hero-title">
                        {!! nl2br(e(site_setting('hero_title', "Now\nIt's easy for you\nto move your car"))) !!}
                    </h1>
                    <p class="hero-description">
                        {{ site_setting('hero_description', 'We provide safe and reliable vehicle transportation services to your desired location.') }}
                    </p>
                    <p class="mt-4">
                        <a href="{{ site_setting('hero_button_url', '#request-quote') }}" class="btn btn-primary py-3 px-4 hero-cta">
                            {{ site_setting('hero_button_text', 'Request a Quote') }}
                        </a>
                    </p>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 d-flex justify-content-end hero-form-col">
                <form id="moveRequestForm"
                    action="{{ route('car-movers.request') }}"
                    method="POST"
                    class="request-form hero-form ftco-animate">
                    @csrf

                    <h2 class="text-center mb-3">{{ site_setting('hero_form_title', 'Request a Move') }}</h2>

                    <div class="hero-form-scroll">

                        <div class="form-group">
                            <label class="label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>

                        <div class="form-group">
                            <label class="label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                        </div>

                        <div class="form-group">
                            <label class="label">Contact Number</label>
                            <input type="text" name="contact_no" class="form-control" placeholder="Mobile Number" required>
                        </div>

                        <div class="form-group">
                            <label class="label">Pick-up Location</label>
                            <input type="text" name="pickup_location" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="label">Drop-off Location</label>
                            <input type="text" name="drop_location" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="label">Pickup State</label>
                            <select name="pickup_state_id" class="form-control" required>
                                <option value="">Select Pickup State</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="label">Drop State</label>
                            <select name="drop_state_id" class="form-control" required>
                                <option value="">Select Drop State</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="label">Vehicle Type</label>
                            <select name="car_type_id" class="form-control" required>
                                <option value="">Select Vehicle Type</option>
                                @foreach($carTypes as $carType)
                                <option value="{{ $carType->id }}">{{ $carType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="label">Price Range</label>
                            <input type="text" name="price_range" class="form-control" placeholder="10000-15000">
                        </div>

                    </div>{{-- end .hero-form-scroll --}}

                    <div class="hero-form-footer">
                        <div id="formMsg" class="mb-2"></div>
                        <button type="submit" class="btn btn-primary w-100 hero-submit" id="submitBtn">
                            <span class="btn-text">Request Move</span>
                            <span class="spinner-border spinner-border-sm d-none" id="loader"></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#moveRequestForm').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');
            let data = form.serialize();

            $('#loader').removeClass('d-none');
            $('.btn-text').text('Submitting...');
            $('#submitBtn').prop('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(res) {
                    $('#loader').addClass('d-none');
                    $('.btn-text').text('Request Move');
                    $('#submitBtn').prop('disabled', false);

                    if (res.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Request Submitted',
                            text: res.message,
                            confirmButtonColor: '#ff8c00'
                        });
                        form[0].reset();
                    }
                },
                error: function(xhr) {
                    $('#loader').addClass('d-none');
                    $('.btn-text').text('Request Move');
                    $('#submitBtn').prop('disabled', false);

                    let message = 'Please check all fields';
                    if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                    } else if (xhr.responseJSON?.errors) {
                        message = Object.values(xhr.responseJSON.errors).flat()[0];
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: message,
                        confirmButtonColor: '#d33'
                    });
                }
            });
        });
    });
</script>
@endpush
@push('styles')
<style>
    .hero-home {
        min-height: 740px;
        padding-top: 70px;
        padding-bottom: 20px;
        overflow: hidden;
    }

    .hero-home .hero-home-row {
        min-height: 660px;
        align-items: stretch;
    }

    .hero-home .hero-copy-col {
        padding-right: 30px;
    }

    .hero-home .hero-copy {
        max-width: 600px;
    }

    .hero-home .hero-title {
        font-size: clamp(40px, 4.4vw, 66px);
        line-height: 0.96;
        font-weight: 300;
        letter-spacing: -0.03em;
        color: #fff;
        margin-bottom: 22px;
    }

    .hero-home .hero-kicker {
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.85);
    }

    .hero-home .hero-title span {
        color: #fff;
    }

    .hero-home .hero-description {
        max-width: 560px;
        font-size: 17px;
        line-height: 1.5;
        color: rgba(255, 255, 255, 0.95);
    }

    .hero-home .hero-cta {
        background: #ff9b35;
        border-color: #ff9b35;
        color: #fff;
    }

    .hero-home .hero-form-col {
        padding-left: 18px;
        align-items: flex-start;
        /* ← align to top, not stretch */
        padding-top: 0;
        /* ← no extra top gap */
    }

    /* ── FORM ── */
    .hero-home .hero-form {
        width: 100%;
        max-width: 370px;
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.22);
        display: flex;
        flex-direction: column;
        max-height: 620px;
        padding: 16px 20px 0;
        /* ← tighter top padding */
        overflow: hidden;
        margin-top: 0;
        /* ← no top margin */
    }

    .hero-home .hero-form h2 {
        font-size: 20px;
        font-weight: 700;
        color: #111;
        flex-shrink: 0;
        margin-bottom: 10px;
        /* ← tighter gap after heading */
    }

    /* Scrollable fields area */
    .hero-form-scroll {
        flex: 1;
        overflow-y: auto;
        padding-right: 4px;
        padding-bottom: 4px;
    }

    .hero-form-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .hero-form-scroll::-webkit-scrollbar-track {
        background: #f5f5f5;
        border-radius: 2px;
    }

    .hero-form-scroll::-webkit-scrollbar-thumb {
        background: #ff9b35;
        border-radius: 2px;
    }

    /* Sticky footer */
    .hero-form-footer {
        flex-shrink: 0;
        padding: 10px 0 16px;
        background: #fff;
        border-top: 1px solid #f0f0f0;
        margin-top: 4px;
    }

    .hero-home .hero-form .label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.02em;
        margin-bottom: 4px;
    }

    .hero-home .hero-form .form-control {
        height: 38px;
        border-radius: 0;
        font-size: 13px;
    }

    .hero-home .hero-form .form-group {
        margin-bottom: 10px;
    }

    .hero-home .hero-submit {
        height: 42px;
        background: #ff9b35;
        border-color: #ff9b35;
        border-radius: 0;
        font-weight: 700;
    }

    /* ── Hero row vertical alignment fix ── */
    .hero-home .hero-home-row.align-items-center {
        align-items: flex-start !important;
        /* override Bootstrap centering */
        padding-top: 20px;
        /* small top breathing room */
    }

    .hero-home .hero-copy-col {
        padding-top: 60px;
        /* push copy down visually to center it */
    }

    @media (max-width: 991.98px) {
        .hero-home {
            min-height: auto;
            padding-top: 110px;
            padding-bottom: 24px;
        }

        .hero-home .hero-home-row {
            min-height: auto;
        }

        .hero-home .hero-copy-col,
        .hero-home .hero-form-col {
            padding-left: 0;
            padding-right: 0;
            padding-top: 0;
        }

        .hero-home .hero-form {
            max-width: 100%;
            max-height: 520px;
            margin-top: 28px;
        }

        .hero-home .hero-home-row.align-items-center {
            padding-top: 0;
        }
    }

    @media (max-width: 767.98px) {
        .hero-home .hero-title {
            font-size: 40px;
        }

        .hero-home .hero-description {
            font-size: 16px;
        }

        .hero-home .hero-form {
            max-height: 480px;
        }
    }
</style>
@endpush
