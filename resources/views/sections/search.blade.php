<section class="ftco-section search-home-section ftco-no-pb ftco-no-pt">
    <div class="container">
        <div class="search-home-wrap">
            <form id="priceSearchForm" class="search-property-1">
                <div class="row align-items-end">
                    <div class="col-lg col-md-6">
                        <div class="form-group">
                            <label>Pickup State</label>
                            <select name="pickup_state" class="form-control" required>
                                <option value="">Select Pickup State</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg col-md-6">
                        <div class="form-group">
                            <label>Drop State</label>
                            <select name="drop_state" class="form-control" required>
                                <option value="">Select Drop State</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg col-md-6">
                        <div class="form-group">
                            <label>Car Type</label>
                            <select name="car_type" class="form-control" required>
                                <option value="">Select Car Type</option>
                                @foreach($carTypes as $car)
                                    <option value="{{ $car->id }}">{{ $car->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg col-md-6">
                        <div class="form-group">
                            <label>Price Range</label>
                            <input type="text" name="price_range" class="form-control" placeholder="10000-15000">
                        </div>
                    </div>

                    <div class="col-lg col-md-6 align-self-end">
                        <button type="submit" class="btn btn-primary w-100 search-btn">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div id="searchResults"></div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
$(function () {
    $('#priceSearchForm').on('submit', function (e) {
        e.preventDefault();

        $('#searchResults').html('<p>Loading...</p>');

        $.ajax({
            url: "{{ route('frontend.price-search') }}",
            method: "GET",
            data: $(this).serialize(),
            success: function (data) {
                let html = `
                <h5 class="mb-3">Search Results</h5>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Pickup</th>
                            <th>Drop</th>
                            <th>Car Type</th>
                            <th>Price (₹)</th>
                        </tr>
                    </thead>
                    <tbody>`;

                if (Array.isArray(data) && data.length > 0) {
                    data.forEach((row, i) => {
                        html += `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${row.pickup_state_name}</td>
                            <td>${row.drop_state_name}</td>
                            <td>${row.car_type_name}</td>
                            <td>₹ ${row.price}</td>
                        </tr>`;
                    });
                } else {
                    html += `
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                            No price list found
                        </td>
                    </tr>`;
                }

                html += `
                    </tbody>
                </table>

                <div class="mt-3">
                    <a href="{{ route('contact') }}" class="btn btn-success me-2">
                        Contact Us
                    </a>
                    <a href="tel:+911234567890" class="btn btn-primary">
                        Call Now
                    </a>
                </div>`;

                $('#searchResults').html(html);
            },
            error: function () {
                $('#searchResults').html(`
                    <table class="table table-bordered">
                        <tr>
                            <td class="text-center text-danger">
                                Something went wrong
                            </td>
                        </tr>
                    </table>
                    <div class="mt-3">
                        <a href="{{ route('contact') }}" class="btn btn-success me-2">Contact Us</a>
                        <a href="tel:+911234567890" class="btn btn-primary">Call Now</a>
                    </div>
                `);
            }
        });
    });
});
</script>
@endpush

@push('styles')
<style>
    .search-home-section {
        background: #fff;
        padding-top: 0;
    }

    .search-home-wrap {
        position: relative;
        z-index: 5;
        margin-top: -38px;
        background: #fff;
        padding: 30px 25px 18px;
    }

    .search-property-1 label {
        display: block;
        font-size: 14px;
        font-weight: 700;
        color: #444;
        margin-bottom: 10px;
    }

    .search-property-1 .form-control {
        height: 52px;
        border-radius: 0;
        background: #fff;
    }

    .search-btn {
        height: 52px;
        background: #ff9b35;
        border-color: #ff9b35;
        border-radius: 0;
        font-weight: 700;
    }

    @media (max-width: 991.98px) {
        .search-home-wrap {
            margin-top: 0;
            padding: 24px 0 0;
        }
    }
</style>
@endpush
