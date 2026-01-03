@extends('admin.layouts.dashboard')
@section('title', 'General Website Settings')

@section('content')
<div class="container-fluid">

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0 fw-bold">General Website Settings</h4>
            <small class="opacity-75">Manage website basic configuration & API keys</small>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('settings-general.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">

                    {{-- WEBSITE NAME --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Website Name</label>
                        <input type="text" name="site_name"
                               class="form-control"
                               value="{{ setting('site_name') }}"
                               placeholder="Enter website name">
                    </div>

                    {{-- WEBSITE EMAIL --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Website Email</label>
                        <input type="email" name="site_email"
                               class="form-control"
                               value="{{ setting('site_email') }}"
                               placeholder="Enter email">
                    </div>

                    {{-- LOGO --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Website Logo</label>
                        <input type="file" name="site_logo" class="form-control">
                        @if(setting('site_logo'))
                        
    <img src="{{ asset('uploads/settings/' . setting('site_logo')) }}"
         class="mt-2"
         style="height:50px">
@endif

                       
                    </div>

                    {{-- FAVICON --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Favicon</label>
                        <input type="file" name="site_favicon" class="form-control">
                        @if(setting('site_favicon'))
                            <img src="{{ asset('uploads/settings/' . setting('site_favicon')) }}"
                                 class="mt-2"
                                 style="height:40px">
                        @endif
                    </div>

                    <hr>

                    {{-- WHATSAPP APP KEY --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">WhatsApp App Key</label>
                        <input type="text" name="whatsapp_app_key"
                               class="form-control"
                               value="{{ setting('whatsapp_app_key') }}"
                               placeholder="Enter WhatsApp App Key">
                    </div>

                    {{-- WHATSAPP AUTH KEY --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">WhatsApp Auth Key</label>
                        <input type="text" name="whatsapp_auth_key"
                               class="form-control"
                               value="{{ setting('whatsapp_auth_key') }}"
                               placeholder="Enter WhatsApp Auth Key">
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-success px-4">
                        <i class="mdi mdi-content-save"></i> Save Settings
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
