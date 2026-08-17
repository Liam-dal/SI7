@php
    $menu = [
        ['label' => 'Projects', 'url' => route('projects'), 'active' => request()->routeIs('projects*')],
        ['label' => 'About', 'url' => route('about'), 'active' => request()->routeIs('about') || request()->routeIs('people.show')],
        ['label' => 'Downloads', 'url' => route('downloads'), 'active' => request()->routeIs('downloads')],
        ['label' => 'Contact', 'url' => route('contact'), 'active' => request()->routeIs('contact')],
    ];

    // 로고: 관리자에 이미지가 붙어 있으면 그걸, 없으면 리포에 번들된 SVG를 사용.
    // (Twill은 SVG를 이미지 필드에 저장하지 못해 관리자 업로드가 안 붙으므로 기본 로고를 코드로 보장)
    $logoMedia = $siteSettings?->medias?->firstWhere('pivot.role', 'logo');
    $logoUrl = $logoMedia
        ? \A17\Twill\Services\MediaLibrary\ImageService::getRawUrl($logoMedia->uuid)
        : asset('img/logo.svg');
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
        <div class="lang-switch" data-lang-switch>
            <button class="lang-switch__toggle" type="button" data-lang-toggle aria-haspopup="true" aria-expanded="false" aria-label="언어 선택 ({{ strtoupper(app()->getLocale()) }})">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" aria-hidden="true">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9 9 0 1 0 0-18m0 18a9 9 0 1 1 0-18m0 18c2.761 0 3.941-5.163 3.941-9S14.761 3 12 3m0 18c-2.761 0-3.941-5.163-3.941-9S9.239 3 12 3M3.5 9h17m-17 6h17"/>
                </svg>
            </button>
            <div class="lang-switch__menu" data-lang-menu hidden>
                <a href="{{ route('locale.switch', 'ko') }}" @if(app()->getLocale() === 'ko') class="is-on" aria-current="true" @endif>KO</a>
                <a href="{{ route('locale.switch', 'en') }}" @if(app()->getLocale() === 'en') class="is-on" aria-current="true" @endif>EN</a>
            </div>
        </div>
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
        <span class="lang-switch lang-switch--mobile" aria-label="언어">
            <a href="{{ route('locale.switch', 'ko') }}" @if(app()->getLocale() === 'ko') class="is-on" @endif>KO</a>
            <a href="{{ route('locale.switch', 'en') }}" @if(app()->getLocale() === 'en') class="is-on" @endif>EN</a>
        </span>
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

// 언어 전환 지구본 드롭다운
(() => {
    const wrap = document.querySelector('[data-lang-switch]');
    if (!wrap) return;
    const toggle = wrap.querySelector('[data-lang-toggle]');
    const menu = wrap.querySelector('[data-lang-menu]');
    const setOpen = (open) => { menu.hidden = !open; toggle.setAttribute('aria-expanded', String(open)); };
    toggle.addEventListener('click', (e) => { e.stopPropagation(); setOpen(menu.hidden); });
    document.addEventListener('click', (e) => { if (!wrap.contains(e.target)) setOpen(false); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpen(false); });
})();
</script>
@endpush
