@extends('admin.layouts.dashboard')
@section('title', 'Create Request List')
@section('content')
<div class="container-fluid py-3">
  <div class="bg-white p-4 rounded-3 shadow-sm">
    <h4 class="fw-bold mb-4">Create Request</h4>

    <form action="{{ route('property-requests.store') }}" method="POST">
      @include('admin.requests.form')
    </form>
  </div>
</div>
@endsection
