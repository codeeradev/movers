@extends('admin.layouts.dashboard')

@section('title', 'Edit Car Shifting Step')

@section('content')
<div class="container-fluid">
    <h4>Edit Car Shifting Step</h4>

    <form 
        method="POST" 
        action="{{ route('car-process.update', $process->id) }}" 
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        @include('admin.car-process._form', ['process' => $process])
    </form>
</div>
@endsection
