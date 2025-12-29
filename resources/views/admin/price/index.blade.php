@extends('admin.layouts.dashboard') {{-- Layout use kar rahe ho --}}

@section('title', 'Price List') {{-- Page title set --}}

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Price List</h4>
        <a href="{{ route('price-list.create') }}" class="btn btn-primary">
            + Add Price
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Pickup State</th>
                        <th>Drop State</th>
                        <th>Car Type</th>
                        <th>Price (₹)</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rates as $rate)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rate->pickupState->name ?? '-' }}</td>
                            <td>{{ $rate->dropState->name ?? '-' }}</td>
                            <td>{{ $rate->carType->name ?? '-' }}</td>
                        <td>{{ $rate->price }}</td>

                            <td>{{ config('constants.status')[$rate->status] ?? '-' }}</td>
                            <td>
                                <a href="{{ route('price-list.edit', $rate->id) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('price-list.destroy', $rate->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this price?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No price list found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
