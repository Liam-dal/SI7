{{-- 사이트 헤더 — Figma si7-homepage node 30:19.
     3등분 레이아웃: 왼쪽 로고 / 가운데 메뉴 / 오른쪽 언어전환 + Contact 필.
     세 칼럼이 모두 flex:1 이라 로고나 버튼 폭이 변해도 가운데 메뉴는 정확히 가운데에 남는다.
     메뉴 항목 구성은 관리자 > Site settings > Header menu 토글을 따른다(chrome.blade.php 에서 계산). --}}
@props([
    'menu' => [],
    'contact' => null,
    'logoUrl' => null,
    'logoAlt' => 'SI7',
])

<header class="site-header">
    <div class="site-header__lead">
        <a class="site-logo" href="{{ route('home') }}" aria-label="홈">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}">
            @else
                {{ $logoAlt }}
            @endif
        </a>
    </div>

    <nav class="site-nav" aria-label="주요 메뉴">
        @foreach($menu as $link)
            <a href="{{ $link['url'] }}" @if($link['active']) aria-current="page" @endif>{{ $link['label'] }}</a>
        @endforeach
    </nav>

    <div class="site-header__actions">
        @if($contact)
            <a class="site-cta" href="{{ $contact['url'] }}" @if($contact['active']) aria-current="page" @endif>{{ $contact['label'] }}</a>
        @endif

        {{-- 지구본은 Figma 에서 Contact 필과 같은 높이의 정사각 회색 버튼 — KO/EN 드롭다운. --}}
        <div class="lang-switch" data-lang-switch>
            <button class="lang-switch__toggle" type="button" data-lang-toggle aria-haspopup="true" aria-expanded="false" aria-label="언어 선택 ({{ strtoupper(app()->getLocale()) }})">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" aria-hidden="true">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9 9 0 1 0 0-18m0 18a9 9 0 1 1 0-18m0 18c2.761 0 3.941-5.163 3.941-9S14.761 3 12 3m0 18c-2.761 0-3.941-5.163-3.941-9S9.239 3 12 3M3.5 9h17m-17 6h17"/>
                </svg>
            </button>
            <div class="lang-switch__menu" data-lang-menu hidden>
                <a href="{{ route('locale.switch', 'ko') }}" @if(app()->getLocale() === 'ko') class="is-on" aria-current="true" @endif>KO</a>
                <a href="{{ route('locale.switch', 'en') }}" @if(app()->getLocale() === 'en') class="is-on" aria-current="true" @endif>EN</a>
            </div>
        </div>

        <button class="nav-toggle" type="button" data-nav-open aria-expanded="false" aria-controls="mobile-nav">Menu</button>
    </div>
</header>
