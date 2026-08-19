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
        {{-- Glide 기본 출력이 webp라 그대로 두면 Safari가 파비콘을 렌더링하지 못한다.
             파비콘만 png 로 강제하고 크기별 링크를 명시한다. --}}
        @php
            $faviconUrl = fn (int $size) => $siteSettings->image('favicon', 'default', ['fm' => 'png', 'w' => $size, 'h' => $size]);
        @endphp
        <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl(32) }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ $faviconUrl(192) }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ $faviconUrl(180) }}">
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
