@extends('admin.layouts.dashboard')

@section('title', 'Add Car Type')

@section('content')
<div class="container-fluid">
    <h4>Add Car Type</h4>

    <form method="POST" action="{{ route('car-types.store') }}">
        @include('admin.car-types._form')
    </form>
</div>
@endsection
