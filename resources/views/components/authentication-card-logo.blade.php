@php
    $authLogo = site_setting('logo');
    $authSiteName = site_setting('site_name', config('app.name', 'Laravel'));
@endphp

<a href="{{ url('/') }}" class="inline-flex flex-col items-center justify-center">
    @if($authLogo && file_exists(public_path('uploads/settings/' . $authLogo)))
        <img
            src="{{ asset('uploads/settings/' . $authLogo) }}"
            alt="{{ $authSiteName }}"
            class="block h-16 w-auto object-contain">
    @else
        <span class="text-2xl font-bold tracking-tight text-gray-900">
            {{ $authSiteName }}
        </span>
    @endif
</a>
