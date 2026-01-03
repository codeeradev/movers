@extends('admin.layouts.dashboard')
@section('title', ($type == 1 ? 'Add Buy Inquiry' : 'Add Sell Inquiry'))


@section('content')
<div class="card shadow-lg border-0 rounded-4">

    <!-- ========================= PAGE HEADER ========================= -->
    <div class="card-header bg-primary text-white px-4 py-3 rounded-top-4 d-flex justify-content-between align-items-center">
       <h4 class="mb-0 fw-bold">
    {{ $type == 1 ? 'Add Buy Inquiry' : 'Add Sell Inquiry' }}
</h4>


        <a href="{{ route('inquiries.index') }}" class="btn btn-light btn-sm fw-semibold shadow-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <!-- ========================= FORM BODY ========================= -->
    <div class="card-body p-4">

        <form action="{{ route('inquiries.store') }}" method="POST">
            @csrf

            {{-- COMMON FORM --}}
            @include('admin.enquiries.buy.form')

            <div class="mt-4">
                <button class="btn btn-success fw-semibold">
                    <i class="bi bi-check-circle"></i> Save Inquiry
                </button>

                <a href="{{ route('inquiries.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>
@endsection
