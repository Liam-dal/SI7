<style>
    :root { --rule: var(--text); }
    * { box-sizing: border-box; }
    body { margin: 0; background: var(--page-bg); color: var(--text); font-family: 'SI7', Arial, sans-serif; font-size: var(--body-size); line-height: var(--body-leading); letter-spacing: var(--body-tracking); }
    a { color: inherit; }
    .site-header { display: flex; align-items: center; justify-content: space-between; gap: 24px; padding: 15px var(--page-pad); font-size: var(--menu-size); line-height: var(--menu-leading); letter-spacing: var(--menu-tracking); }
    .site-logo { display: block; font-weight: 600; text-decoration: none; }
    .site-logo img { display: block; width: auto; max-width: 160px; height: 24px; }
    .site-nav { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 8px 20px; }
    .site-nav a { text-underline-offset: 3px; }
    .site-nav a[aria-current='page'] { font-weight: 700; }
    .site-footer { display: flex; justify-content: space-between; gap: 24px; flex-wrap: wrap; margin-top: 120px; padding: 16px var(--page-pad); border-top: 1px solid var(--rule); font-size: var(--body-small-size); line-height: var(--body-small-leading); letter-spacing: var(--body-small-tracking); }
    .site-footer p { margin: 0; max-width: 420px; }
    .site-footer p + p { margin-top: 12px; }
    .site-footer nav { display: flex; gap: 18px; }
    @media (max-width: 767px) { :root { --page-pad: 12px; } .site-header { padding-top: 13px; padding-bottom: 13px; } .site-nav { gap: 8px 14px; } .site-footer { margin-top: 72px; } }
</style>

<header class="site-header">
    <a class="site-logo" href="{{ route('home') }}" aria-label="홈">
        @if($siteSettings?->hasImage('logo'))
            <img src="{{ $siteSettings->image('logo') }}" alt="{{ $siteSettings->logo_text ?: '홈' }}">
        @else
            {{ $siteSettings?->logo_text ?: 'PORTFOLIO' }}
        @endif
    </a>
    <nav class="site-nav" aria-label="주요 메뉴">
        <a href="{{ route('projects') }}" @if(request()->routeIs('projects*')) aria-current="page" @endif>Work</a>
        <a href="{{ route('downloads') }}" @if(request()->routeIs('downloads')) aria-current="page" @endif>Downloads</a>
        <a href="{{ route('contact') }}" @if(request()->routeIs('contact')) aria-current="page" @endif>Contact</a>
    </nav>
</header>
