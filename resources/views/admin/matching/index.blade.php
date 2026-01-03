@extends('admin.layouts.dashboard')

@section('content')

@php
    $request_statuses = config('constants.request_statuses');
@endphp

<div class="card shadow-lg border-0 rounded-4">
  <div class="card-header bg-dark text-white rounded-top-4 py-3 px-4">
    <h4 class="mb-0 fw-bold">Matching Requests</h4>
  </div>

  <div class="card-body rounded-bottom-4">

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle text-center shadow-sm rounded-3">
        <thead class="table-dark text-white">
          <tr>
            <th>Buyer Name</th>
            <th>Buyer Contact</th>
            <th>Buyer Location</th>
            <th>Seller Name</th>
            <th>Seller Contact</th>
            <th>Seller Location</th>
            <th>Match Details</th>
          </tr>
        </thead>
        <tbody>

          @forelse($matches as $m)
          <tr>
            <td class="fw-bold text-primary">{{ $m->buy_name }}</td>
            <td>{{ $m->buy_contact }}</td>
            <td>{{ $m->buy_location }}</td>

            <td class="fw-bold text-success">{{ $m->sell_name }}</td>
            <td>{{ $m->sell_contact }}</td>
            <td>{{ $m->sell_location }}</td>

            <td>
              <button class="btn btn-outline-primary btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#matchModal{{ $m->buy_id }}">
                View
              </button>
            </td>
          </tr>

          {{-- MODAL --}}
          <div class="modal fade" id="matchModal{{ $m->buy_id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content rounded-4 shadow-lg">

                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title">Match Details</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                  <div class="row g-4">

                    {{-- BUYER --}}
                    <div class="col-md-6">
                      <div class="border rounded-3 p-3 bg-white shadow-sm">
                        <h6 class="fw-bold text-primary">Buyer</h6>
                        <p><strong>Name:</strong> {{ $m->buy_name }}</p>
                        <p><strong>Phone:</strong> {{ $m->buy_contact }}</p>
                        <p><strong>Location:</strong> {{ $m->buy_location }}</p>

                        <label class="fw-bold mt-2">Buyer Status</label>
                        <select class="form-select status-select" data-id="{{ $m->buy_id }}">
                          @foreach($request_statuses as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    {{-- SELLER --}}
                    <div class="col-md-6">
                      <div class="border rounded-3 p-3 bg-white shadow-sm">
                        <h6 class="fw-bold text-success">Seller</h6>
                        <p><strong>Name:</strong> {{ $m->sell_name }}</p>
                        <p><strong>Phone:</strong> {{ $m->sell_contact }}</p>
                        <p><strong>Location:</strong> {{ $m->sell_location }}</p>

                        <label class="fw-bold mt-2">Seller Status</label>
                        <select class="form-select status-select" data-id="{{ $m->sell_id }}">
                          @foreach($request_statuses as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                  </div>

                </div>

                <div class="modal-footer">
                  <button class="btn btn-primary update-status-btn"
                    data-buy="{{ $m->buy_id }}"
                    data-sell="{{ $m->sell_id }}">
                    Update Status
                  </button>

                  <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

              </div>
            </div>
          </div>

          @empty
            <tr>
              <td colspan="7" class="text-muted">No matching requests found.</td>
            </tr>
          @endforelse

        </tbody>
      </table>
    </div>

  </div>
</div>

@endsection


{{-- 🎯 FINAL SCRIPT BLOCK (Runs After jQuery Loaded) --}}
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).on("click", ".update-status-btn", function () {

    let buyID  = $(this).data("buy");
    let sellID = $(this).data("sell");

    let buyStatus  = $(`select[data-id='${buyID}']`).val();
    let sellStatus = $(`select[data-id='${sellID}']`).val();

    $.ajax({
        url: "{{ route('matching.requests.update-status') }}",
        type: "POST",
        data: {
            buy_id: buyID,
            sell_id: sellID,
            buy_status: buyStatus,
            sell_status: sellStatus,
            _token: "{{ csrf_token() }}"
        },
        success: function () {
            Swal.fire({
                title: "Status Updated!",
                text: "Buyer & Seller statuses updated successfully.",
                icon: "success"
            }).then(() => location.reload());
        },
        error: function () {
            Swal.fire({
                title: "Error!",
                text: "Unable to update status.",
                icon: "error"
            });
        }
    });

});
</script>

@endpush
