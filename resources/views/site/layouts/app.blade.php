<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- 검색엔진 색인 차단 (사이트 전체). robots.txt 와 함께 이중으로 차단. --}}
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    @php
        $siteName = $siteSettings?->site_name ?: ($siteSettings?->logo_text ?: 'SI7');
        $ogImage = $siteSettings?->hasImage('og_image') ? $siteSettings->image('og_image') : null;
    @endphp
    <title>@hasSection('title')@yield('title') — {{ $siteName }}@else{{ $siteName }}@endif</title>
    @hasSection('description')<meta name="description" content="@yield('description')">@endif

    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="@hasSection('title')@yield('title')@else{{ $siteName }}@endif">
    @hasSection('description')<meta property="og:description" content="@yield('description')">@endif
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endif
    @if($siteSettings?->hasImage('favicon'))
        <link rel="icon" href="{{ $siteSettings->image('favicon') }}">
        <link rel="apple-touch-icon" href="{{ $siteSettings->image('favicon') }}">
    @endif

    @include('site.partials.tokens')
    @if(is_file(public_path('hot')) || is_file(public_path('build/manifest.json')))
        @vite(['resources/css/site.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ route('site.css') }}?v={{ filemtime(resource_path('css/site.css')) }}">
    @endif
    @stack('styles')
</head>
<body>
    @include('site.partials.chrome')
    <main id="content">
        @yield('content')
    </main>
    @include('site.partials.footer')
    @stack('scripts')
</body>
</html>
