@extends('admin.layouts.dashboard')

@section('title', $title)

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header">
        <h4>{{ $title }}</h4>
    </div>

    <div class="card-body">

        
        <form action="{{ route('settings.manage.save', $type) }}" method="POST">
            @csrf

            {{-- Category dropdown only for subcategory --}}
            @if($type === 'subcategory')
                <div class="mb-3">
                    <label class="form-label">Select Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Choose Category --</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">Enter {{ ucfirst($type) }} Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <button class="btn btn-primary">Add {{ ucfirst($type) }}</button>
        </form>

        <hr>

        <h5 class="mt-4">Existing {{ ucfirst($type) }}s</h5>

        <ul class="list-group mt-2">

            {{-- Sector List --}}
            @if($type === 'sector')
                @foreach($items as $item)
                    <li class="list-group-item">
                        {{ $item->name }}
                    </li>
                @endforeach
            @endif

            {{-- Category List --}}
            @if($type === 'category')
                @foreach($items as $item)
                    <li class="list-group-item">
                        {{ $item->name }}
                    </li>
                @endforeach
            @endif

            {{-- Subcategory List with Category Name --}}
            @if($type === 'subcategory')
                @foreach($items as $item)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>
                            {{ $item->name }}  
                            <br>
                            <small class="text-muted">Category: {{ $item->category->name ?? '-' }}</small>
                        </span>
                    </li>
                @endforeach
            @endif

        </ul>

    </div>
</div>

@endsection
