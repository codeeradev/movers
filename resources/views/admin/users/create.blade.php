@extends('admin.layouts.dashboard')
@section('title', 'Add New Employee')
@section('content')
<div class="card shadow-lg border-0 rounded-4">
  <div class="card-header bg-success text-white rounded-top-4">
      <h4 class="mb-0 fw-bold">➕ Add New Employee</h4>
  </div>

  <div class="card-body">
      <form action="{{ route('employees.store') }}" method="POST">
          @csrf
          @include('admin.users.form')
      </form>
  </div>
</div>
@endsection
