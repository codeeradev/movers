@extends('admin.layouts.dashboard')

@section('title', 'Add Price')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Add Price</h4>
        <a href="{{ route('price-list.index') }}" class="btn btn-secondary">Back to Price List</a>
    </div>


    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('price-list.store') }}">
                @include('admin.price._form')
            </form>
        </div>
    </div>

</div>
@endsection
