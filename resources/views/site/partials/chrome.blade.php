@php
    $menu = [
        ['label' => 'Projects', 'url' => route('projects'), 'active' => request()->routeIs('projects*')],
        ['label' => 'About', 'url' => route('about'), 'active' => request()->routeIs('about') || request()->routeIs('people.show')],
        ['label' => 'Guide', 'url' => route('guides'), 'active' => request()->routeIs('guides*')],
        ['label' => 'Downloads', 'url' => route('downloads'), 'active' => request()->routeIs('downloads')],
        ['label' => 'Contact', 'url' => route('contact'), 'active' => request()->routeIs('contact')],
    ];

    // 로고 미디어를 크롭과 무관하게 직접 찾아 원본 URL을 사용 (SVG는 크롭이 없어 hasImage/image로는 안 잡힘).
    $logoMedia = $siteSettings?->medias?->firstWhere('pivot.role', 'logo');
    $logoUrl = $logoMedia
        ? \A17\Twill\Services\MediaLibrary\ImageService::getRawUrl($logoMedia->uuid)
        : null;
    $logoAlt = $siteSettings?->logo_text ?: 'SI7';
@endphp

<a class="skip-link" href="#content">본문으로 건너뛰기</a>

<header class="site-header">
    <a class="site-logo" href="{{ route('home') }}" aria-label="홈">
        @if($logoUrl)
            <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}">
        @else
            {{ $logoAlt }}
        @endif
    </a>
    <nav class="site-nav" aria-label="주요 메뉴">
        @foreach($menu as $link)
            <a href="{{ $link['url'] }}" @if($link['active']) aria-current="page" @endif>{{ $link['label'] }}</a>
        @endforeach
    </nav>
    <button class="nav-toggle" type="button" data-nav-open aria-expanded="false" aria-controls="mobile-nav">Menu</button>
</header>

<div class="nav-overlay" id="mobile-nav" data-open="false" aria-hidden="true">
    <header>
        <span class="site-logo">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}">
            @else
                {{ $logoAlt }}
            @endif
        </span>
        <button class="nav-toggle" type="button" data-nav-close>Close</button>
    </header>
    <nav aria-label="모바일 메뉴">
        @foreach($menu as $link)
            <a href="{{ $link['url'] }}" @if($link['active']) aria-current="page" @endif>{{ $link['label'] }}</a>
        @endforeach
    </nav>
</div>

@push('scripts')
<script>
(() => {
    const overlay = document.getElementById('mobile-nav');
    const opener = document.querySelector('[data-nav-open]');
    if (!overlay || !opener) return;
    const setOpen = (open) => {
        overlay.dataset.open = String(open);
        overlay.setAttribute('aria-hidden', String(!open));
        opener.setAttribute('aria-expanded', String(open));
        document.body.style.overflow = open ? 'hidden' : '';
        if (open) overlay.querySelector('nav a')?.focus(); else opener.focus();
    };
    opener.addEventListener('click', () => setOpen(true));
    overlay.querySelector('[data-nav-close]')?.addEventListener('click', () => setOpen(false));
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape' && overlay.dataset.open === 'true') setOpen(false); });
})();
</script>
@endpush
