@csrf

{{-- Agar edit page hai to method PUT --}}
@if(isset($rate) && $rate->exists)
    @method('PUT')
@endif

{{-- Pickup State --}}
<div class="mb-3">
    <label for="pickup_state" class="form-label">Pickup State</label>
    <select name="pickup_state" id="pickup_state" class="form-control" required>
        <option value="">Select Pickup State</option>
        @foreach($states as $state)
            <option value="{{ $state->id }}"
                {{ old('pickup_state', $rate->pickup_state ?? '') == $state->id ? 'selected' : '' }}>
                {{ $state->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- Drop State --}}
<div class="mb-3">
    <label for="drop_state" class="form-label">Drop State</label>
    <select name="drop_state" id="drop_state" class="form-control" required>
        <option value="">Select Drop State</option>
        @foreach($states as $state)
            <option value="{{ $state->id }}"
                {{ old('drop_state', $rate->drop_state ?? '') == $state->id ? 'selected' : '' }}>
                {{ $state->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- Car Type --}}
<div class="mb-3">
    <label for="car_type" class="form-label">Car Type</label>
    <select name="car_type" id="car_type" class="form-control" required>
        <option value="">Select Car Type</option>
        @foreach($carTypes as $car)
            <option value="{{ $car->id }}"
                {{ old('car_type', $rate->car_type ?? '') == $car->id ? 'selected' : '' }}>
                {{ $car->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- Price Range --}}
<div class="mb-3">
    <label for="price" class="form-label">Price Range (₹)</label>
    <input type="text"
           name="price"
           id="price"
           class="form-control"
           placeholder="e.g. 11,000 - 15,000"
           value="{{ old('price', $rate->price ?? '') }}"
           required>
</div>


{{-- Status --}}
<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" id="status" class="form-control" required>
        <option value="">Select Status</option>
        @foreach(config('constants.status') as $key => $label)
            <option value="{{ $key }}" {{ old('status', $carType->status ?? '') == $key ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>

<button class="btn btn-success">{{ isset($rate) && $rate->exists ? 'Update' : 'Save' }}</button>
<a href="{{ route('price-list.index') }}" class="btn btn-secondary">Cancel</a>
