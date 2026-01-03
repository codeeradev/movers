@extends('admin.layouts.dashboard')
<style>
    #event_type {
        height: 55px;
        font-size: 18px;
    }
</style>


@section('content')
<div class="card shadow-lg border-0 rounded-4">
  <div class="card-header bg-primary text-white rounded-top-4">
    <h4 class="mb-0 fw-bold">Add Message (Birthday / Festival)</h4>
  </div>

  <div class="card-body">
    <form action="{{ route('messages.store') }}" method="POST" id="messageForm">
      @csrf
      <div class="row g-3">
        <!-- Title -->
        <div class="col-md-6">
          <label class="form-label">Title</label>
          <input type="text" name="title" class="form-control" placeholder="e.g. Diwali, Birthday" required>
        </div>

        <!-- Type -->
    <div class="form-group col-md-6">
    <label>Event Type</label>
    <select id="event_type" name="event_type" class="form-control form-control-lg">
        <option value="">Select Event Type</option>

        @foreach(config('constants.event_types') as $key => $label)
            <option value="{{ $key }}"
                {{ old('event_type', $event->event_type ?? '') == $key ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>



        <!-- Event Date (hidden for birthday) -->
        <div class="col-md-6" id="dateField" style="display:none;">
          <label class="form-label">Event Date</label>
          <input type="date" name="event_date" id="eventDate" class="form-control">
        </div>

        <!-- Message Template -->
        <div class="col-12">
          <label class="form-label">Message Template</label>
          <textarea name="message_template" class="form-control" rows="3"
            placeholder="Happy Diwali, {name}! Wishing you joy and success."></textarea>
          <small class="text-muted">Use <b>{name}</b> where you want the user’s name.</small>
        </div>

        <div class="col-12 text-end">
          <button type="submit" class="btn btn-success">Save Message</button>
        </div>
      </div>
    </form>
  </div>

  <div class="card-footer text-end">
    <a href="{{ route('messages.send') }}" class="btn btn-warning">Send Today’s Messages</a>
  </div>
</div>

<!-- Simple JS to show/hide date -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('typeSelect');
    const dateField = document.getElementById('dateField');
    const dateInput = document.getElementById('eventDate');

    typeSelect.addEventListener('change', function() {
      if (this.value === 'festival') {
        dateField.style.display = 'block';
        dateInput.required = true;
      } else {
        dateField.style.display = 'none';
        dateInput.required = false;
        dateInput.value = '';
      }
    });
  });
</script>
@endsection
