@extends('admin.layouts.dashboard')

@section('title', 'View Plot Details')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <h4 class="mb-0">Plot Details</h4>
        <a href="{{ route('plots.index') }}" class="btn btn-light btn-sm">
            <i class="mdi mdi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card-body">

        {{-- Basic Information --}}
        <h5 class="text-dark mb-3 fw-bold">Owner Information</h5>

        <div class="row mb-4">
            <div class="col-md-4">
                <strong>Owner Name:</strong>
                <p>{{ $plot->owner_name ?? '-' }}</p>
            </div>

            <div class="col-md-4">
                <strong>Contact Number:</strong>
                <p>{{ $plot->contact_number ?? '-' }}</p>
            </div>

            <div class="col-md-4">
                <strong>Email:</strong>
                <p>{{ $plot->email ?? '-' }}</p>
            </div>

            <div class="col-md-4">
                <strong>Date of Birth:</strong>
                <p>{{ $plot->dob ?? '-' }}</p>
            </div>

            <div class="col-md-4">
                <strong>Father Name:</strong>
                <p>{{ $plot->father_name ?? '-' }}</p>
            </div>

            <div class="col-md-4">
                <strong>Address:</strong>
                <p>{{ $plot->address ?? '-' }}</p>
            </div>
        </div>

        {{-- Plot Information --}}
        <h5 class="text-dark mb-3 fw-bold">Plot / Property Information</h5>

        <div class="row mb-4">
            <div class="col-md-4">
                <strong>Plot Number:</strong>
                <p>{{ $plot->property_number ?? '-' }}</p>
            </div>

            <div class="col-md-4">
                <strong>Khewat Number:</strong>
                <p>{{ $plot->khewat_number ?? '-' }}</p>
            </div>

            <div class="col-md-4">
                <strong>Khasra Number:</strong>
                <p>{{ $plot->khasra_number ?? '-' }}</p>
            </div>

            <div class="col-md-4">
                <strong>Plot Size:</strong>
                <p>{{ $plot->plot_size ?? '-' }}</p>
            </div>

            <div class="col-md-4">
                <strong>Property Type:</strong>
                <p>{{ $plot->property_type ?? '-' }}</p>
            </div>

            <div class="col-md-4">
                <strong>Price:</strong>
                <p>{{ $plot->price }}</p>
            </div>

            <div class="col-md-4">
                <strong>Location:</strong>
                <p>{{ $plot->location ?? '-' }}</p>
            </div>

            <div class="col-md-8">
                <strong>Landmark:</strong>
                <p>{{ $plot->landmark ?? '-' }}</p>
            </div>

            <div class="col-md-12">
                <strong>Description:</strong>
                <p>{{ $plot->description ?? 'No description available.' }}</p>
            </div>
        </div>

        {{-- Category & Sector Info --}}
        <h5 class="text-dark mb-3 fw-bold">Sector / Category Details</h5>

        <div class="row">
            <div class="col-md-4">
                <strong>Sector:</strong>
                <p>{{ $plot->sector->name ?? '-' }}</p>
            </div>

            <div class="col-md-4">
                <strong>Category:</strong>
                <p>{{ $plot->category->name ?? '-' }}</p>
            </div>

            <div class="col-md-4">
                <strong>Subcategory:</strong>
                <p>{{ $plot->subcategory->name ?? '-' }}</p>
            </div>
        </div>

        {{-- Status --}}
        <div class="row mt-4">
            <div class="col-md-4">
    <strong>Status:</strong><br>

    @if($plot->status == 1)
       <span class="badge bg-success text-white px-3 py-2 fs-6 rounded-pill shadow-sm">
    Active
</span>

    @else
        <span class="badge bg-danger text-white px-3 py-2 fs-6 rounded-pill shadow-sm">
    Inactive
</span>

    @endif
</div>


            <div class="col-md-4">
                <strong>Created At:</strong>
                <p>{{ $plot->created_at->format('d M Y h:i A') }}</p>
            </div>

            <div class="col-md-4">
                <strong>Updated At:</strong>
                <p>{{ $plot->updated_at->format('d M Y h:i A') }}</p>
            </div>
        </div>

        <hr>

        {{-- Actions --}}
        <div class="mt-3">
            <a href="{{ route('plots.edit', $plot->id) }}" class="btn btn-warning">
                <i class="mdi mdi-pencil"></i> Edit
            </a>

            <a href="{{ route('plots.index') }}" class="btn btn-secondary">
                <i class="mdi mdi-arrow-left"></i> Back to List
            </a>
        </div>

    </div>
</div>

@endsection
