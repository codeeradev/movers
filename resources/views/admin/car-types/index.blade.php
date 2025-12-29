@extends('admin.layouts.dashboard')

@section('title', 'Car Types List')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Car Types List</h4>
        <a href="{{ route('car-types.create') }}" class="btn btn-primary">
            + Add Car Type
        </a>
    </div>

  

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Car Type</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($carTypes as $type)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $type->name }}</td>
                            <td>{{ config('constants.status')[$type->status] ?? 'Unknown' }}</td>
                            <td>
                                <a href="{{ route('car-types.edit', $type->id) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('car-types.destroy', $type->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this car type?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No car types found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
