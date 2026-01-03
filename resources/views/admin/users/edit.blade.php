@extends('admin.layouts.dashboard')
@section('title', 'Edit Employee')
@section('content')
<div class="card shadow-lg border-0 rounded-4">
  <div class="card-header bg-warning text-dark rounded-top-4">
      <h4 class="mb-0 fw-bold">✏️ Edit Employee</h4>
  </div>

  <div class="card-body">
      <form action="{{ route('employees.update', $employee->id) }}" method="POST">
          @csrf
          @method('PUT')
          @include('admin.users.form')
      </form>
  </div>
</div>
@endsection
