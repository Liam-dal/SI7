@php
    // 항목별 노출 여부는 관리자 > Site settings > Header menu 에서 켜고 끈다.
    // 설정 행이 아직 없을 때는 기존 기본값(Guides 제외 전부 노출)을 따른다.
    $menuEnabled = fn (string $field, bool $default) => $siteSettings && array_key_exists($field, $siteSettings->getAttributes())
        ? (bool) $siteSettings->{$field}
        : $default;

    // Contact 는 헤더에서 필 버튼으로 따로 나가므로(디자인) 가운데 메뉴 목록과 분리한다.
    // 모바일 오버레이에서는 예전처럼 다른 항목들과 같은 링크로 이어 붙인다.
    $menu = collect([
        ['label' => 'Projects', 'url' => route('projects'), 'active' => request()->routeIs('projects*'), 'show' => $menuEnabled('menu_projects_enabled', true)],
        ['label' => 'About', 'url' => route('about'), 'active' => request()->routeIs('about') || request()->routeIs('people.show'), 'show' => $menuEnabled('menu_about_enabled', true)],
        ['label' => 'Guides', 'url' => route('guides'), 'active' => request()->routeIs('guides*'), 'show' => $menuEnabled('menu_guides_enabled', false)],
        ['label' => 'Downloads', 'url' => route('downloads'), 'active' => request()->routeIs('downloads'), 'show' => $menuEnabled('menu_downloads_enabled', true)],
    ])->filter(fn ($link) => $link['show'])->values();

    $contact = $menuEnabled('menu_contact_enabled', true)
        ? ['label' => 'Contact', 'url' => route('contact'), 'active' => request()->routeIs('contact')]
        : null;

    // concat 은 새 컬렉션을 돌려준다 — push 면 $menu 가 변형돼 가운데 메뉴에도 Contact 가 들어간다.
    $mobileMenu = $contact ? $menu->concat([$contact]) : $menu;

    // 로고: 관리자에 이미지가 붙어 있으면 그걸, 없으면 리포에 번들된 SVG를 사용.
    // (Twill은 SVG를 이미지 필드에 저장하지 못해 관리자 업로드가 안 붙으므로 기본 로고를 코드로 보장)
    $logoMedia = $siteSettings?->medias?->firstWhere('pivot.role', 'logo');
    $logoUrl = $logoMedia
        ? \A17\Twill\Services\MediaLibrary\ImageService::getRawUrl($logoMedia->uuid)
        : asset('img/logo.svg');
    $logoAlt = $siteSettings?->logo_text ?: 'SI7';
@endphp

<a class="skip-link" href="#content">본문으로 건너뛰기</a>

<x-site.header
    :menu="$menu"
    :contact="$contact"
    :logo-url="$logoUrl"
    :logo-alt="$logoAlt"
/>

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
        @foreach($mobileMenu as $link)
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

// 헤더 스크롤 숨김/표시 (아래로 스크롤 → 숨김, 위로 → 표시)
(() => {
    const header = document.querySelector('.site-header');
    if (!header) return;
    let lastY = window.scrollY, ticking = false;
    const onScroll = () => {
        const y = window.scrollY;
        if (y > lastY && y > header.offsetHeight) header.classList.add('is-hidden');
        else header.classList.remove('is-hidden');
        lastY = y <= 0 ? 0 : y;
        ticking = false;
    };
    window.addEventListener('scroll', () => { if (!ticking) { requestAnimationFrame(onScroll); ticking = true; } }, { passive: true });
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
