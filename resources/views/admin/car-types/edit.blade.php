@extends('admin.layouts.dashboard')

@section('title', 'Edit Car Type')

@section('content')
<div class="container-fluid">
    <h4>Edit Car Type</h4>

    <form method="POST" action="{{ route('car-types.update', $carType->id) }}">
        @include('admin.car-types._form')
    </form>
</div>
@endsection
