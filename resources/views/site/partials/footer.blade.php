<footer class="site-footer" style="display:flex; justify-content:space-between; gap:24px; flex-wrap:wrap; margin-top:96px; padding:16px; border-top:1px solid currentColor; font-size:14px;">
    <div>
        @if($siteSettings?->footer_text)<p style="margin:0; max-width:420px;">{{ $siteSettings->footer_text }}</p>@endif
        <p style="margin:{{ $siteSettings?->footer_text ? '12px' : '0' }} 0 0;">{{ $siteSettings?->copyright_text ?: '© ' . now()->year }}</p>
    </div>
    <nav style="display:flex; gap:18px; align-items:flex-start;" aria-label="소셜 링크">
        @if($siteSettings?->instagram_url)<a href="{{ $siteSettings->instagram_url }}" target="_blank" rel="noreferrer">Instagram ↗</a>@endif
        @if($siteSettings?->linkedin_url)<a href="{{ $siteSettings->linkedin_url }}" target="_blank" rel="noreferrer">LinkedIn ↗</a>@endif
        @if($siteSettings?->behance_url)<a href="{{ $siteSettings->behance_url }}" target="_blank" rel="noreferrer">Behance ↗</a>@endif
    </nav>
</footer>
