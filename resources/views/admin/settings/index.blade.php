@extends('admin.layouts.dashboard')

@section('title', 'Settings')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">
        <h3 class="text-dark">Website Settings</h3>
        <p class="text-muted mb-0">Manage general website configuration</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" data-toggle="tab" href="#general">
                            General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" data-toggle="tab" href="#contact">
                            Contact
                        </a>
                    </li>
                </ul>

                <div class="tab-content">

                    <!-- 🔹 General Tab -->
                    <div class="tab-pane fade show active" id="general">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold text-dark">Website Name</label>
                                <input
                                    type="text"
                                    name="site_name"
                                    class="form-control bg-white text-dark"
                                    value="{{ old('site_name', $settings->site_name ?? '') }}"
                                    placeholder="Enter website name"
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold text-dark">Footer Text</label>
                                <input
                                    type="text"
                                    name="footer_text"
                                    class="form-control bg-white text-dark"
                                    value="{{ old('footer_text', $settings->footer_text ?? '') }}"
                                    placeholder="Footer copyright text"
                                >
                            </div>

                            <!-- Logo -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold text-dark">Website Logo</label>
                                <input type="file" name="logo" class="form-control bg-white">
                                @if(!empty($settings?->logo))
                                    <div class="mt-2">
                                        <img 
                                            src="{{ asset('uploads/settings/'.$settings->logo) }}" 
                                            height="50"
                                            class="img-thumbnail bg-light"
                                        >
                                    </div>
                                @endif
                            </div>

                            <!-- Favicon -->
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold text-dark">Favicon</label>
                                <input type="file" name="favicon" class="form-control bg-white">
                                @if(!empty($settings?->favicon))
                                    <div class="mt-2">
                                        <img 
                                            src="{{ asset('uploads/settings/'.$settings->favicon) }}" 
                                            height="32"
                                            class="img-thumbnail bg-light"
                                        >
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                    <!-- 🔹 Contact Tab -->
                    <div class="tab-pane fade" id="contact">
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-dark">Phone</label>
                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control bg-white text-dark"
                                    value="{{ old('phone', $settings->phone ?? '') }}"
                                    placeholder="+91 XXXXX XXXXX"
                                >
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold text-dark">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control bg-white text-dark"
                                    value="{{ old('email', $settings->email ?? '') }}"
                                    placeholder="support@example.com"
                                >
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold text-dark">Address</label>
                                <textarea
                                    name="address"
                                    class="form-control bg-white text-dark"
                                    rows="3"
                                    placeholder="Office address"
                                >{{ old('address', $settings->address ?? '') }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
    <label class="font-weight-bold text-dark">
        Google Map Embed (iframe)
    </label>

    <textarea
        name="google_map"
        class="form-control bg-white text-dark"
        rows="4"
        placeholder="Paste Google Map iframe here"
    >{{ old('google_map', $settings->google_map ?? '') }}</textarea>

    <small class="text-muted">
        Google Maps → Share → Embed a map → Copy iframe code
    </small>
</div>

@if(!empty($settings?->google_map))
    <div class="col-md-12 mt-3">
        <div class="border rounded p-2 bg-light">
            {!! $settings->google_map !!}
        </div>
    </div>
@endif


                        </div>
                    </div>

                </div>

                <div class="text-right mt-4">
                    <button class="btn btn-primary px-4">
                        Save Settings
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
