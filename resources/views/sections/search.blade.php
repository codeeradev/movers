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
                                    <label for="pickup_state">Pickup State</label>
                                    <select name="pickup_state" id="pickup_state" class="form-control" required>
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
                                    <label for="drop_state">Drop State</label>
                                    <select name="drop_state" id="drop_state" class="form-control" required>
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
                                    <label for="car_type">Car Type</label>
                                    <select name="car_type" id="car_type" class="form-control" required>
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
                                    <label for="price_range">Price Range</label>
                                    <input type="text" name="price_range" id="price_range" class="form-control" placeholder="e.g. 10000-15000">
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-lg align-self-end">
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Search Results --}}
        <div class="row mt-4">
            <div class="col-md-12">
                <div id="searchResults"></div>
            </div>
        </div>
    </div>
</section>


<script>
$(document).ready(function(){
    $('#priceSearchForm').on('submit', function(e){
        e.preventDefault();

        $.ajax({
            url: "{{ route('frontend.price-search') }}",
            type: "GET",
            data: $(this).serialize(),
            success: function(data){
                let html = '';
                if(data.length > 0){
                    html += '<h5>Search Results:</h5>';
                    html += '<table class="table table-striped table-bordered">';
                    html += '<thead class="table-dark"><tr><th>#</th><th>Pickup State</th><th>Drop State</th><th>Car Type</th><th>Price (₹)</th></tr></thead>';
                    html += '<tbody>';
                    $.each(data, function(i, rate){
                        html += '<tr>';
                        html += '<td>'+(i+1)+'</td>';
                        html += '<td>'+rate.pickup_state_name+'</td>';
                        html += '<td>'+rate.drop_state_name+'</td>';
                        html += '<td>'+rate.car_type_name+'</td>';
                        html += '<td>'+rate.price+'</td>';
                        html += '</tr>';
                    });
                    html += '</tbody></table>';
                    html += '<div class="mt-3 d-flex gap-2">';
                    html += '<a href="{{ route('contact') }}" class="btn btn-success">Contact Us</a>';
                    html += '<a href="tel:+911234567890" class="btn btn-primary">Call Now</a>';
                    html += '</div>';
                } else {
                    html = '<p>No price list found</p>';
                }
                $('#searchResults').html(html);
            },
            error: function(err){
                alert('Something went wrong. Please try again.');
            }
        });
    });
});
</script>
