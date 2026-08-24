@php
    // 풋터 로고는 리포에 번들된 SI7 마크 고정 — 리퀴드 셰이더가 이 로고에서 미리 구운
    // 거리장 맵(logo-liquid.png)을 텍스처로 쓰기 때문에 관리자 업로드 로고와 짝이 맞지 않는다.
    $footerLogo = asset('img/logo.svg');
    $footerLogoMap = asset('img/logo-liquid.png');
@endphp

<footer class="site-footer">
    <div class="site-footer__mark" data-liquid-logo data-speed="0.15" data-liquid="0.07" data-edge="0.4">
        {{-- WebGL2 가 없거나 모션 최소화 설정이면 이 SVG 가 그대로 남는다. --}}
        <img class="site-footer__mark-fallback" src="{{ $footerLogo }}" alt="SI7" data-liquid-fallback>
        <canvas class="site-footer__mark-canvas" data-map="{{ $footerLogoMap }}" aria-hidden="true"></canvas>
    </div>

    <div class="site-footer__body">
        <div>
            @if($siteSettings?->footer_text)<p>{{ $siteSettings->footer_text }}</p>@endif
            <p>{{ $siteSettings?->copyright_text ?: '© ' . now()->year }}</p>
        </div>
        <nav aria-label="소셜 링크">
            @if($siteSettings?->instagram_url)<a href="{{ $siteSettings->instagram_url }}" target="_blank" rel="noreferrer">Instagram ↗</a>@endif
            @if($siteSettings?->linkedin_url)<a href="{{ $siteSettings->linkedin_url }}" target="_blank" rel="noreferrer">LinkedIn ↗</a>@endif
            @if($siteSettings?->behance_url)<a href="{{ $siteSettings->behance_url }}" target="_blank" rel="noreferrer">Behance ↗</a>@endif
        </nav>
    </div>
</footer>

@include('site.partials.liquid-logo')
