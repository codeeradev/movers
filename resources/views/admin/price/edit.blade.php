@extends('admin.layouts.dashboard')

@section('title', 'Edit Price')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Edit Price</h4>
        <a href="{{ route('price-list.index') }}" class="btn btn-secondary">Back to Price List</a>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('price-list.update', $rate->id) }}">
                @include('admin.price._form')
            </form>
        </div>
    </div>

</div>
@endsection
