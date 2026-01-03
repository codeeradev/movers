@extends('layouts.app')

@section('title', 'Home')

@section('content')

 <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Contact <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Contact us</h1>
          </div>
        </div>
      </div>
    </section>

		<section class="ftco-section contact-section">
      <div class="container">
        <div class="row d-flex mb-5 contact-info justify-content-center">
        	<div class="col-md-8">
        		<div class="row mb-5">
		          <div class="col-md-4 text-center py-4">
		          	<div class="icon">
		          		<span class="icon-map-o"></span>
		          	</div>
		           <p>
    <span>Address:</span>
    {{ site_setting('address', 'Address not available') }}
</p>

		          </div>
		          <div class="col-md-4 text-center border-height py-4">
		          	<div class="icon">
		          		<span class="icon-mobile-phone"></span>
		          	</div>
		       <p>
    <span>Phone:</span>
    <a href="tel:{{ site_setting('phone') }}">
        {{ site_setting('phone', 'N/A') }}
    </a>
</p>

		          </div>
		          <div class="col-md-4 text-center py-4">
		          	<div class="icon">
		          		<span class="icon-envelope-o"></span>
		          	</div>
		          <p>
    <span>Email:</span>
    <a href="mailto:{{ site_setting('email') }}">
        {{ site_setting('email', 'N/A') }}
    </a>
</p>

		          </div>
		        </div>
          </div>
        </div>
        <div class="row block-9 justify-content-center mb-5">
          <div class="col-md-8 mb-md-5">
          	<h2 class="text-center">If you got any questions <br>please do not hesitate to send us a message</h2>
          <form id="contactForm"
      action="{{ route('contact.submit') }}"
      method="POST"
      class="bg-light p-5 contact-form">
    @csrf

    <!-- Name -->
<div class="form-group">
    <input type="text"
           name="name"
           class="form-control"
           placeholder="Your Name">
    <small class="text-danger error-text" data-error="name"></small>
</div>

<!-- Email -->
<div class="form-group">
    <input type="email"
           name="email"
           class="form-control"
           placeholder="Your Email">
    <small class="text-danger error-text" data-error="email"></small>
</div>

<!-- Phone -->
<div class="form-group">
    <input type="text"
           name="phone"
           class="form-control"
           placeholder="Your Phone Number">
    <small class="text-danger error-text" data-error="phone"></small>
</div>

<!-- Message -->
<div class="form-group">
    <textarea name="message"
              rows="7"
              class="form-control"
              placeholder="Your Message"></textarea>
    <small class="text-danger error-text" data-error="message"></small>
</div>


    <!-- Submit -->
  <div class="form-group text-center">
    <button type="submit"
            id="submitBtn"
            class="btn btn-primary py-3 px-5 d-flex align-items-center justify-content-center gap-2">
        <span id="btnText">Send Message</span>
        <span id="btnSpinner"
              class="spinner-border spinner-border-sm d-none"
              role="status"
              aria-hidden="true"></span>
    </button>
</div>

</form>

          
          </div>
        </div>
        <div class="row justify-content-center">
      @if(site_setting('google_map'))
    <div class="col-md-10">
        <div id="map" class="bg-white">
            {!! site_setting('google_map') !!}
        </div>
    </div>
@endif

        </div>
      </div>
    </section>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');

    function clearErrors() {
        document.querySelectorAll('.error-text').forEach(el => el.textContent = '');
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();

        submitBtn.disabled = true;
        btnText.textContent = 'Sending...';
        btnSpinner.classList.remove('d-none');

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async res => {
            if (!res.ok) {
                const errorData = await res.json();
                throw errorData;
            }
            return res.json();
        })
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: data.message
            });
            form.reset();
        })
        .catch(err => {
            if (err.errors) {
                Object.keys(err.errors).forEach(field => {
                    const input = form.querySelector(`[name="${field}"]`);
                    const errorBox = document.querySelector(`[data-error="${field}"]`);
                    if (input) input.classList.add('is-invalid');
                    if (errorBox) errorBox.textContent = err.errors[field][0];
                });
            } else {
                Swal.fire('Error', 'Something went wrong', 'error');
            }
        })
        .finally(() => {
            submitBtn.disabled = false;
            btnText.textContent = 'Send Message';
            btnSpinner.classList.add('d-none');
        });
    });

});
</script>

@endpush