@php
    // 시그니처 마크는 리포에 번들된 SI7 로고 고정 — 리퀴드 셰이더가 이 로고에서 미리 구운
    // 거리장 맵(logo-liquid.png)을 텍스처로 쓰기 때문에 관리자 업로드 로고와 짝이 맞지 않는다.
    $signatureLogo = asset('img/logo.svg');
    $signatureLogoMap = asset('img/logo-liquid.png');
@endphp

{{-- Figma: si7-homepage 32:126 — 뷰포트 바닥에 깔려 있다가 본문이 지나가며 드러나는 검정 패널.
     워드마크는 헤더에 이미 있으니 여기서는 순수 장식이라 접근성 트리에서 빼둔다. 랜드마크가
     둘이 되지 않도록 <footer> 가 아니라 <div> 로 둔다. --}}
<div class="site-signature" aria-hidden="true">
    <div class="site-signature__inner">
        <div class="site-signature__mark" data-liquid-logo data-speed="0.15" data-liquid="0.07" data-edge="0.4">
            {{-- WebGL2 가 없거나 모션 최소화 설정이면 이 SVG 가 그대로 남는다. --}}
            <img class="site-signature__mark-fallback" src="{{ $signatureLogo }}" alt="" data-liquid-fallback>
            <canvas class="site-signature__mark-canvas" data-map="{{ $signatureLogoMap }}"></canvas>
        </div>
    </div>
</div>

@include('site.partials.liquid-logo')
