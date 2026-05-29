@extends('admin.layouts.dashboard')

@section('title', 'Website Settings')

@section('content')
@php
    $chooseItems = old('home_choose_items', $settings?->home_choose_items ?: $defaults['home_choose_items']);
    $statItems = old('home_stats_items', $settings?->home_stats_items ?: $defaults['home_stats_items']);
@endphp

<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-0">Website Settings</h3>
        <small class="text-muted">Manage branding, contact details, and homepage content</small>
    </div>

    <form method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <strong>General</strong>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Website Name</label>
                        <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings->site_name ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $settings->phone ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $settings->email ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Footer Text</label>
                        <input type="text" name="footer_text" class="form-control" value="{{ old('footer_text', $settings->footer_text ?? '') }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address', $settings->address ?? '') }}</textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Google Map Embed</label>
                        <textarea name="google_map" class="form-control" rows="4">{{ old('google_map', $settings->google_map ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Logo</label>
                        <input type="file" name="logo" class="form-control">
                        @if(!empty($settings?->logo))
                            <img src="{{ asset('uploads/settings/'.$settings->logo) }}" alt="Logo" class="mt-2" style="height:50px">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Favicon</label>
                        <input type="file" name="favicon" class="form-control">
                        @if(!empty($settings?->favicon))
                            <img src="{{ asset('uploads/settings/'.$settings->favicon) }}" alt="Favicon" class="mt-2" style="height:32px">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <strong>Hero Section</strong>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Hero Subtitle</label>
                        <input type="text" name="hero_subtitle" class="form-control" value="{{ old('hero_subtitle', $settings->hero_subtitle ?? $defaults['hero_subtitle']) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Hero Button Text</label>
                        <input type="text" name="hero_button_text" class="form-control" value="{{ old('hero_button_text', $settings->hero_button_text ?? $defaults['hero_button_text']) }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Hero Title</label>
                        <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $settings->hero_title ?? $defaults['hero_title']) }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Hero Description</label>
                        <textarea name="hero_description" class="form-control" rows="4">{{ old('hero_description', $settings->hero_description ?? $defaults['hero_description']) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Hero Button URL</label>
                        <input type="text" name="hero_button_url" class="form-control" value="{{ old('hero_button_url', $settings->hero_button_url ?? $defaults['hero_button_url']) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Hero Form Title</label>
                        <input type="text" name="hero_form_title" class="form-control" value="{{ old('hero_form_title', $settings->hero_form_title ?? $defaults['hero_form_title']) }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Hero Background Image</label>
                        <input type="file" name="hero_background_image" class="form-control">
                        @if(!empty($settings?->hero_background_image))
                            <img src="{{ asset('uploads/settings/'.$settings->hero_background_image) }}" alt="Hero background" class="mt-2 img-fluid rounded" style="max-height:180px">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <strong>Why Choose Us</strong>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Choose Subtitle</label>
                        <input type="text" name="home_choose_subtitle" class="form-control" value="{{ old('home_choose_subtitle', $settings->home_choose_subtitle ?? $defaults['home_choose_subtitle']) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Choose Title</label>
                        <input type="text" name="home_choose_title" class="form-control" value="{{ old('home_choose_title', $settings->home_choose_title ?? $defaults['home_choose_title']) }}">
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    @foreach($chooseItems as $index => $item)
                        <div class="col-lg-4">
                            <div class="border rounded p-3 h-100">
                                <div class="fw-semibold mb-2">Feature {{ $index + 1 }}</div>
                                <div class="mb-2">
                                    <label class="form-label">Icon Class</label>
                                    <input type="text" name="home_choose_items[{{ $index }}][icon]" class="form-control" value="{{ $item['icon'] ?? '' }}" placeholder="flaticon-search">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="home_choose_items[{{ $index }}][title]" class="form-control" value="{{ $item['title'] ?? '' }}">
                                </div>
                                <div>
                                    <label class="form-label">Description</label>
                                    <textarea name="home_choose_items[{{ $index }}][description]" class="form-control" rows="3">{{ $item['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <strong>Statistics</strong>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Stats Subtitle</label>
                        <input type="text" name="home_stats_subtitle" class="form-control" value="{{ old('home_stats_subtitle', $settings->home_stats_subtitle ?? $defaults['home_stats_subtitle']) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Stats Title</label>
                        <input type="text" name="home_stats_title" class="form-control" value="{{ old('home_stats_title', $settings->home_stats_title ?? $defaults['home_stats_title']) }}">
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    @foreach($statItems as $index => $item)
                        <div class="col-md-3">
                            <div class="border rounded p-3 h-100">
                                <div class="fw-semibold mb-2">Stat {{ $index + 1 }}</div>
                                <div class="mb-2">
                                    <label class="form-label">Value</label>
                                    <input type="text" name="home_stats_items[{{ $index }}][value]" class="form-control" value="{{ $item['value'] ?? '' }}" placeholder="5000+">
                                </div>
                                <div>
                                    <label class="form-label">Label</label>
                                    <input type="text" name="home_stats_items[{{ $index }}][label]" class="form-control" value="{{ $item['label'] ?? '' }}" placeholder="Vehicles Delivered">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">Save Settings</button>
        </div>
    </form>
</div>
@endsection
