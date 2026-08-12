<footer class="site-footer">
    <div>
        @if($siteSettings?->footer_text)<p>{{ $siteSettings->footer_text }}</p>@endif
        <p>{{ $siteSettings?->copyright_text ?: '© ' . now()->year }}</p>
    </div>
    <nav aria-label="소셜 링크">
        @if($siteSettings?->instagram_url)<a href="{{ $siteSettings->instagram_url }}" target="_blank" rel="noreferrer">Instagram ↗</a>@endif
        @if($siteSettings?->linkedin_url)<a href="{{ $siteSettings->linkedin_url }}" target="_blank" rel="noreferrer">LinkedIn ↗</a>@endif
        @if($siteSettings?->behance_url)<a href="{{ $siteSettings->behance_url }}" target="_blank" rel="noreferrer">Behance ↗</a>@endif
    </nav>
</footer>
