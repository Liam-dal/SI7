{{-- Figma: si7-homepage 32:91 — 규칙선 아래 저작권과 연락 링크만 있는 한 줄 풋터.
     큰 SI7 마크는 풋터 정보가 아니라 페이지 끝 브랜드 사인이라 site-signature 로 분리했다. --}}
<footer class="site-footer">
    <div class="site-footer__row">
        <p>{{ $siteSettings?->copyright_text ?: '© ' . now()->year . ' SI7' }}</p>
        <a class="site-footer__contact" href="{{ route('contact') }}">Get in touch</a>
    </div>
</footer>
