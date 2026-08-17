<style>
    :root {
        --page-bg: {{ $siteSettings?->background_color ?: '#FFFFFF' }};
        --text: {{ $siteSettings?->text_color ?: '#111111' }};
        --muted: {{ $siteSettings?->muted_text_color ?: '#6E6E6E' }};
        --rule: var(--text);
        --page-pad: {{ $siteSettings?->page_gutter ?? 16 }}px;
        --section-space: {{ $siteSettings?->section_spacing ?? 96 }}px;
        --page-head-gap: var(--space-13);
        --card-radius: {{ $siteSettings?->card_radius ?? 0 }}px;
        --page-title-size: {{ $siteSettings?->page_title_size ?? 140 }}px;
        --page-title-leading: 1.25;
        --page-title-tracking: {{ $siteSettings?->page_title_tracking ?? -0.015 }}em;
        --page-title-2-size: 80px;
        --heading-1: clamp(24px, 2vw, 32px);
        --heading-large: clamp(30px, 3.2vw, 36px);
        --heading-regular: clamp(26px, 2.8vw, 32px);
        --heading-small: clamp(24px, 2.4vw, 28px);
        --heading-xsmall: clamp(20px, 2vw, 24px);
        --page-title-stack-size: clamp(2.2rem, 5vw, var(--page-title-2-size));
        --page-lead-size: var(--body-size);
        --prose-leading: 1.5;
        --prose-leading-loose: 1.75;
        --menu-size: {{ $siteSettings?->menu_size ?? 18 }}px;
        --menu-leading: 1.25;
        --menu-tracking: {{ $siteSettings?->menu_tracking ?? 0 }}em;
        --hero-size: {{ $siteSettings?->hero_title_size ?? 168 }}px;
        --hero-leading: 1.25;
        --hero-tracking: {{ $siteSettings?->hero_title_tracking ?? -0.018 }}em;
        --body-size: {{ $siteSettings?->body_size ?? 18 }}px;
        --body-leading: 1.25;
        --body-tracking: {{ $siteSettings?->body_tracking ?? 0 }}em;
        --body-medium-size: 16px;
        --body-small-size: {{ $siteSettings?->body_small_size ?? 14 }}px;
        --body-small-leading: 1.25;
        --body-small-tracking: {{ $siteSettings?->body_small_tracking ?? 0 }}em;
        --paragraph-size: {{ $siteSettings?->paragraph_size ?? 22 }}px;
        --paragraph-leading: {{ $siteSettings?->paragraph_line_height ?? 1.25 }};
        --paragraph-tracking: {{ $siteSettings?->paragraph_tracking ?? 0 }}em;
        --caption-size: {{ $siteSettings?->caption_size ?? 12 }}px;
        --caption-leading: 1.25;
        --caption-tracking: {{ $siteSettings?->caption_tracking ?? 0.02 }}em;
        --paper: var(--page-bg);
        --ink: var(--text);
        --ink-45: var(--muted);
        --rule-strong: var(--text);
        --surface: #F2F2F2;
        --image-bg: #E4E4E4;
        --space-0: 0px;
        --space-1: 4px;
        --space-2: 6px;
        --space-3: 8px;
        --space-4: 12px;
        --space-5: 16px;
        --space-6: 18px;
        --space-7: 24px;
        --space-8: 28px;
        --space-9: 32px;
        --space-10: 48px;
        --space-11: 64px;
        --space-12: 80px;
        --space-13: 96px;
        --space-14: 120px;
        --gutter: var(--space-5);
        --measure: 720px;
        --radius: var(--card-radius);
    }
    @media (max-width: 767px) { :root { --page-head-gap: var(--space-11); } }
    @font-face { font-family: 'SI7'; src: url('/fonts/si7-regular.woff') format('woff'); font-weight: 400; font-style: normal; font-display: swap; }
    @font-face { font-family: 'SI7'; src: url('/fonts/si7-medium.woff') format('woff'); font-weight: 500 800; font-style: normal; font-display: swap; }
    @if(($siteSettings?->link_hover_style ?? 'underline') === 'fade')
        a:hover { opacity: .56; }
    @else
        a:hover { text-decoration-thickness: 2px; }
    @endif
</style>
