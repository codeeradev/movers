@extends('admin.layouts.dashboard')

@section('title', 'Message System')

@push('styles')
@include('admin.messages.message-style')
{{-- SELECT2 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush



@section('content')

<div class="message-container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card modern-card">
                <div class="card-header card-header-modern">
                    <h4>Send Routine Message</h4>
                </div>

                <div class="card-body card-body-modern">
                    <form action="{{ route('send.sms') }}" method="POST" id="messageForm">
                        @csrf

                        {{-- SEND TYPE --}}
                        <div class="form-group-modern">
                            <label>Send Message By</label>
                            <div class="radio-group">
                                <div class="radio-option">
                                    <input type="radio" name="send_type" value="property" id="byProperty" checked>
                                    <label for="byProperty" class="radio-label">
                                        🏢 By Property
                                    </label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" name="send_type" value="phone" id="byPhone">
                                    <label for="byPhone" class="radio-label">
                                        📱 By Phone
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- PROPERTY SECTION --}}
                        <div id="propertySection">

                            <div class="form-group-modern">
                                <label>Select Category</label>
                                <select id="filterCategory" name="category_id" class="form-select" required>
                                    <option value="">Choose Category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group-modern">
                                <label>Select Sub Category</label>
                                <select id="filterSubcategory" name="subcategory_id" class="form-select">
                                    <option value="">All Sub Categories</option>
                                </select>
                            </div>

                            <div class="form-group-modern">
                                <label>Select Sector</label>
                                <select name="sector_id" class="form-select" required>
                                    <option value="">Choose Sector</option>
                                    @foreach ($sectors as $sec)
                                        <option value="{{ $sec->id }}">{{ $sec->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group-modern">
                                <label>Select Property</label>
                                <select id="filterProperty" name="property_id[]" class="form-select" multiple></select>
                            </div>

                            <div class="range-selector">
                                <div class="range-input">
                                    <input type="number" id="propertyFrom" class="form-control" placeholder="From Property #">
                                </div>
                                <span class="range-separator">→</span>
                                <div class="range-input">
                                    <input type="number" id="propertyTo" class="form-control" placeholder="To Property #">
                                </div>
                                <button type="button" id="selectRange" class="btn btn-primary" style="white-space: nowrap;">
                                    Select Range
                                </button>
                            </div>
                        </div>

                        {{-- PHONE SECTION --}}
                        <div id="phoneSection" style="display:none;">
                            <div class="form-group-modern">
                                <label>Enter Phone Numbers</label>
                                <textarea name="phone_numbers" class="form-control" rows="4"
                                    placeholder="Enter phone numbers separated by commas (e.g., 9876543210, 9123456789)"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-send">
                            <span class="btn-text">Send Message</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {

    /* =======================
       INIT SELECT2
    ======================= */
    function initSelect2() {
        $('#filterProperty').select2({
            placeholder: "Select properties...",
            allowClear: true,
            width: '100%'
        });
    }
    initSelect2();


    /* =======================
       TOGGLE PROPERTY / PHONE
    ======================= */
    $('input[name="send_type"]').on('change', function () {

        if (this.value === 'phone') {
            $('#propertySection').hide();
            setTimeout(() => {
                $('#phoneSection').show();
            }, 100);

            $('#filterCategory, select[name="sector_id"]').prop('required', false);
            $('textarea[name="phone_numbers"]').prop('required', true);

        } else {
            $('#phoneSection').hide();
            setTimeout(() => {
                $('#propertySection').show();
            }, 100);

            $('#filterCategory, select[name="sector_id"]').prop('required', true);
            $('textarea[name="phone_numbers"]').prop('required', false);
        }
    });


    /* =======================
       LOAD SUB CATEGORIES
    ======================= */
    $('#filterCategory').on('change', function () {
        let category_id = $(this).val();
        $('#filterSubcategory').html('<option value="">All Sub Categories</option>');

        if (category_id) {
            $.get('/get-subcategories/' + category_id, function (data) {
                data.forEach(sc => {
                    $('#filterSubcategory').append(
                        `<option value="${sc.id}">${sc.name}</option>`
                    );
                });
            });
        }

        loadProperties();
    });


    /* =======================
       LOAD PROPERTIES
    ======================= */
    function loadProperties() {

        $('#filterProperty').empty();

        $.get("{{ route('properties.filter') }}", {
            category_id: $('#filterCategory').val(),
            subcategory_id: $('#filterSubcategory').val(),
            sector_id: $('select[name="sector_id"]').val()
        }, function (data) {

            $('#filterProperty').empty();

            if (data.length === 0) {
                $('#filterProperty').append('<option value="">No Property Found</option>');
            }

            data.forEach(p => {
                $('#filterProperty').append(
                    `<option value="${p.id}">${p.property_number}</option>`
                );
            });

            initSelect2(); // refresh select2
        });
    }

    $('#filterSubcategory, select[name="sector_id"]').on('change', loadProperties);


    /* =======================
       RANGE SELECT
    ======================= */
    $('#selectRange').on('click', function () {

        let from = parseInt($('#propertyFrom').val());
        let to = parseInt($('#propertyTo').val());

        if (!from || !to || from > to) {
            // Animated alert
            $(this).css('animation', 'shake 0.5s');
            setTimeout(() => {
                $(this).css('animation', '');
            }, 500);
            alert('Please enter a valid range (From must be less than or equal to To)');
            return;
        }

        let selected = [];

        $('#filterProperty option').each(function () {
            let num = parseInt($(this).text());
            if (num >= from && num <= to) {
                selected.push($(this).val());
            }
        });

        $('#filterProperty').val(selected).trigger('change');

        // Success feedback
        $(this).addClass('success-feedback');
        setTimeout(() => {
            $(this).removeClass('success-feedback');
        }, 500);
    });

    // Shake animation for validation
    $('<style>@keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-10px); } 75% { transform: translateX(10px); } }</style>').appendTo('head');


    /* =======================
       SUBMIT LOADER
    ======================= */
    $('#messageForm').on('submit', function () {
        $('.btn-send').addClass('loading').prop('disabled', true);
        $('.btn-text').text('Sending...');
    });

});
</script>

@endsection