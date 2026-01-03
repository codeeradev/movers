@extends('admin.layouts.dashboard')

@section('title', 'Message System')

@push('styles')
    @include('admin.messages.message-style')
    {{-- SELECT2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5>Send WhatsApp Message</h5>
            </div>

            <div class="card-body">

                <form id="messageForm" action="{{ route('whatsapp.messages.send') }}" method="POST">
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

                    {{-- PHONE NUMBERS --}}
                    <div id="phoneBox" class="mb-3">
                        <label class="form-label">Phone Numbers</label>
                        <textarea name="phone_numbers" id="phone_numbers"
                                  class="form-control" rows="4"
                                  placeholder="9876543210, 9123456789"></textarea>
                    </div>

                    {{-- PROPERTY FILTER --}}
                    <div id="propertyBox" style="display:none">

                        <div class="form-group-modern mb-3">
                            <label>Select Category</label>
                            <select id="filterCategory" name="category_id" class="form-select">
                                <option value="">Choose Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-modern mb-3">
                            <label>Select Sub Category</label>
                            <select id="filterSubcategory" name="subcategory_id" class="form-select">
                                <option value="">All Sub Categories</option>
                            </select>
                        </div>

                        <div class="form-group-modern mb-3">
                            <label>Select Sector</label>
                            <select name="sector_id" id="sector_id" class="form-select">
                                <option value="">Choose Sector</option>
                                @foreach ($sectors as $sec)
                                    <option value="{{ $sec->id }}">{{ $sec->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-modern mb-3">
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

                    {{-- MESSAGE --}}
                    <div class="mb-3">
                        <label class="form-label">WhatsApp Message</label>
                        <textarea name="message" class="form-control" rows="4"
                                  placeholder="Type your message here..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100 btn-send">
                        <span class="btn-text">Send WhatsApp</span>
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- SELECT2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const phoneBox = document.getElementById('phoneBox');
    const propertyBox = document.getElementById('propertyBox');
    const radios = document.querySelectorAll('input[name="send_type"]');

    function toggleSendType(value) {
        if (value === 'phone') {
            phoneBox.style.display = 'block';
            propertyBox.style.display = 'none';
            $('#phone_numbers').prop('required', true);
        } else {
            phoneBox.style.display = 'none';
            propertyBox.style.display = 'block';
            $('#phone_numbers').prop('required', false);
        }
    }

    // 🔥 ON PAGE LOAD (IMPORTANT)
    const checkedRadio = document.querySelector('input[name="send_type"]:checked');
    if (checkedRadio) {
        toggleSendType(checkedRadio.value);
    }

    // 🔄 ON CHANGE
    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            toggleSendType(this.value);
        });
    });

});
</script>


<script>
$(document).ready(function () {

    /* =======================
       SELECT2 INIT
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
       LOAD SUB CATEGORIES
    ======================= */
    $('#filterCategory').on('change', function () {
        let id = $(this).val();
        $('#filterSubcategory').html('<option value="">All Sub Categories</option>');

        if (id) {
            $.get('/get-subcategories/' + id, function (data) {
                data.forEach(sc => {
                    $('#filterSubcategory').append(
                        `<option value="${sc.id}">${sc.name}</option>`
                    );
                });
            });
        }
        loadProperties();
    });

    $('#filterSubcategory, #sector_id').on('change', loadProperties);

    /* =======================
       LOAD PROPERTIES
    ======================= */
    function loadProperties() {
        $('#filterProperty').empty();

        $.get("{{ route('properties.filter') }}", {
            category_id: $('#filterCategory').val(),
            subcategory_id: $('#filterSubcategory').val(),
            sector_id: $('#sector_id').val()
        }, function (data) {

            if (data.length === 0) {
                $('#filterProperty').append('<option disabled>No Property Found</option>');
            }

            data.forEach(p => {
                $('#filterProperty').append(
                    `<option value="${p.id}">${p.property_number}</option>`
                );
            });

            initSelect2();
        });
    }

    /* =======================
       RANGE SELECT
    ======================= */
    $('#selectRange').on('click', function () {
        let from = parseInt($('#propertyFrom').val());
        let to = parseInt($('#propertyTo').val());

        if (!from || !to || from > to) {
            alert('Invalid range');
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
    });

    /* =======================
       SUBMIT LOADER
    ======================= */
    $('#messageForm').on('submit', function () {
        $('.btn-send').prop('disabled', true);
        $('.btn-text').text('Sending...');
    });

});
</script>
@endpush
