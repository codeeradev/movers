@extends('admin.layouts.dashboard')
@section('title', 'Edit Request List')
@section('content')
<div class="container-fluid py-3">
  <div class="bg-white p-4 rounded-3 shadow-sm">
    <h4 class="fw-bold mb-4">Edit Request</h4>

    <form action="{{ route('property-requests.update', $requestData->id) }}" method="POST">
      @method('PUT')
      @include('admin.requests.form')
    </form>
  </div>
</div>
@endsection
