<div class="hero-wrap" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>

    <div class="container">
        <div class="row no-gutters slider-text align-items-center">

            <!-- LEFT CONTENT -->
            <div class="col-lg-6 col-md-6 ftco-animate d-flex align-items-end">
                <div class="text">
                    <h1 class="mb-4">
                        Now <span>It's easy for you</span><br>
                        <span>to move your car</span>
                    </h1>
                    <p style="font-size:18px;">
                        We provide safe and reliable vehicle transportation services to your desired location.
                    </p>
                </div>
            </div>

            <div class="col-lg-2"></div>

            <!-- RIGHT FORM -->
            <div class="col-lg-4 col-md-6 d-flex align-items-center">
                <form id="moveRequestForm"
                      action="{{ route('car-movers.request') }}"
                      method="POST"
                      class="request-form ftco-animate"
                      style="
                        background:#fff;
                        padding:35px 30px;
                        border-radius:8px;
                        box-shadow:0 10px 30px rgba(0,0,0,0.2);
                        width:100%;
                      ">
                    @csrf

                    <h2 class="text-center mb-4">Request a Move</h2>

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

                   

                    <div class="form-group mt-4">
                        <button type="submit"
                                class="btn btn-primary w-100"
                                id="submitBtn"
                                style="height:50px;font-weight:600;">
                            <span class="btn-text">Request Move</span>
                            <span class="spinner-border spinner-border-sm d-none" id="loader"></span>
                        </button>
                    </div>

                    <div id="formMsg" class="mt-3"></div>
                </form>
            </div>

        </div>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function () {

    $('#moveRequestForm').on('submit', function (e) {
        console.log('form submit'); // ✅ FIXED
        e.preventDefault();

        let form = $(this);
        let url  = form.attr('action');
        let data = form.serialize();

        $('#loader').removeClass('d-none');
        $('.btn-text').text('Submitting...');
        $('#submitBtn').prop('disabled', true);

        $.ajax({
            url: url,
            type: "POST",
            data: data,

            success: function (res) {
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
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Something went wrong',
                        confirmButtonColor: '#d33'
                    });
                }
            },

            error: function (xhr) {
                $('#loader').addClass('d-none');
                $('.btn-text').text('Request Move');
                $('#submitBtn').prop('disabled', false);

                let msg = 'Please check all fields';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: msg,
                    confirmButtonColor: '#d33'
                });
            }
        });
    });

});
</script>
@endpush
