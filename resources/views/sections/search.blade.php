<section class="ftco-section ftco-no-pb ftco-no-pt">
    <div class="container">

        {{-- Search Form --}}
        <div class="row">
            <div class="col-md-12">
                <div class="search-wrap-1 ftco-animate mb-5">
                    <form id="priceSearchForm" class="search-property-1">
                        <div class="row g-3">

                            {{-- Pickup State --}}
                            <div class="col-lg">
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

                            {{-- Drop State --}}
                            <div class="col-lg">
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

                            {{-- Car Type --}}
                            <div class="col-lg">
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

                            {{-- Price Range --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <label>Price Range</label>
                                    <input type="text" name="price_range" class="form-control"
                                           placeholder="10000-15000">
                                </div>
                            </div>

                            {{-- Button --}}
                            <div class="col-lg align-self-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    Search
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Results --}}
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
                        <a href="{{ route('contact') }}" class="btn btn-success me-2">
                            Contact Us
                        </a>
                        <a href="tel:+911234567890" class="btn btn-primary">
                            Call Now
                        </a>
                    </div>
                `);
            }
        });
    });

});
</script>
@endpush

