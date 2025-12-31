@extends('admin.layouts.dashboard')

@section('title', 'Add Car Shifting Step')

@section('content')
<div class="container-fluid">
    <h4>Add Car Shifting Step</h4>

    <form 
        method="POST" 
        action="{{ route('car-process.store') }}" 
        enctype="multipart/form-data"
    >
        @csrf
        @include('admin.car-process._form', ['process' => null])
    </form>
</div>
@endsection
