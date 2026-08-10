<style>
    :root {
        --page-bg: {{ $siteSettings?->background_color ?: '#FFFFFF' }};
        --text: {{ $siteSettings?->text_color ?: '#111111' }};
        --muted: {{ $siteSettings?->muted_text_color ?: '#6E6E6E' }};
        --page-pad: {{ $siteSettings?->page_gutter ?? 16 }}px;
        --section-space: {{ $siteSettings?->section_spacing ?? 96 }}px;
        --card-radius: {{ $siteSettings?->card_radius ?? 0 }}px;
        --page-title-size: {{ $siteSettings?->page_title_size ?? 140 }}px;
        --page-title-leading: {{ $siteSettings?->page_title_line_height ?? 0.78 }};
        --page-title-tracking: {{ $siteSettings?->page_title_tracking ?? -0.015 }}em;
        --menu-size: {{ $siteSettings?->menu_size ?? 14 }}px;
        --menu-leading: {{ $siteSettings?->menu_line_height ?? 1 }};
        --menu-tracking: {{ $siteSettings?->menu_tracking ?? 0 }}em;
        --hero-size: {{ $siteSettings?->hero_title_size ?? 168 }}px;
        --hero-leading: {{ $siteSettings?->hero_title_line_height ?? 0.82 }};
        --hero-tracking: {{ $siteSettings?->hero_title_tracking ?? -0.018 }}em;
        --body-size: {{ $siteSettings?->body_size ?? 18 }}px;
        --body-leading: {{ $siteSettings?->body_line_height ?? 1.5 }};
        --body-tracking: {{ $siteSettings?->body_tracking ?? 0 }}em;
        --body-small-size: {{ $siteSettings?->body_small_size ?? 14 }}px;
        --body-small-leading: {{ $siteSettings?->body_small_line_height ?? 1.4 }};
        --body-small-tracking: {{ $siteSettings?->body_small_tracking ?? 0 }}em;
        --paragraph-size: {{ $siteSettings?->paragraph_size ?? 22 }}px;
        --paragraph-leading: {{ $siteSettings?->paragraph_line_height ?? 1.35 }};
        --paragraph-tracking: {{ $siteSettings?->paragraph_tracking ?? 0 }}em;
        --caption-size: {{ $siteSettings?->caption_size ?? 12 }}px;
        --caption-leading: {{ $siteSettings?->caption_line_height ?? 1.3 }};
        --caption-tracking: {{ $siteSettings?->caption_tracking ?? 0.02 }}em;
    }
    @font-face {
        font-family: 'SI7';
        src: url('/fonts/si7-regular.woff') format('woff');
        font-weight: 400;
        font-style: normal;
        font-display: swap;
    }
    @font-face {
        font-family: 'SI7';
        src: url('/fonts/si7-medium.woff') format('woff');
        font-weight: 500 800;
        font-style: normal;
        font-display: swap;
    }
    @if(($siteSettings?->link_hover_style ?? 'underline') === 'fade')
        a:hover { opacity: .55; }
    @else
        a:hover { text-decoration-thickness: 1px; text-underline-offset: 4px; }
    @endif
</style>
