@csrf

{{-- Agar edit page hai to method PUT --}}
@if(isset($carType) && $carType->exists)
    @method('PUT')
@endif

<div class="mb-3">
    <label for="name" class="form-label">Car Type</label>
    <input type="text" name="name" id="name" class="form-control"
           value="{{ old('name', $carType->name ?? '') }}" placeholder="Enter Car Type" required>
</div>

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


<button class="btn btn-success">{{ isset($carType) && $carType->exists ? 'Update' : 'Save' }}</button>
<a href="{{ route('car-types.index') }}" class="btn btn-secondary">Cancel</a>
