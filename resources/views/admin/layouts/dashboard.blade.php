<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin Panel')</title>

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @stack('styles')
</head>

<body>
<div class="container-scroller">

  {{-- Navbar --}}
  @include('admin.partials.navbar')

  <div class="container-fluid page-body-wrapper">

    {{-- Sidebar --}}
    @include('admin.partials.sidebar')

    {{-- Main Panel --}}
    <div class="main-panel">
      <div class="content-wrapper">

        {{-- Alerts --}}
        <div class="container-alert">

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
              <i class="bi bi-check-circle-fill"></i>
              <div>{{ session('success') }}</div>
              <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
              <i class="bi bi-x-circle-fill"></i>
              <div>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

        </div>

        {{-- Page Content --}}
        @yield('content')

      </div>

      {{-- Footer --}}
      @include('admin.partials.footer')
    </div>
  </div>
</div>

<!-- ================= JS (CORRECT ORDER – VERY IMPORTANT) ================= -->

<!-- jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Vendor bundle (admin theme scripts, NO bootstrap conflict now) -->
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></hscript>

<!-- Bootstrap 5 (ONLY ONCE, AT BOTTOM) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Theme scripts -->
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/js/misc.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>

{{-- Auto-hide alerts --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
      bootstrap.Alert.getOrCreateInstance(alert).close();
    }, 4000);
  });
});
</script>

@stack('scripts')
</body>
</html>
