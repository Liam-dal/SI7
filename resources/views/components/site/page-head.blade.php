@props(['title' => null, 'description' => null, 'kicker' => null, 'layout' => 'split', 'words' => []])

@php
    // Wysiwyg fields save a cleared value as markup ("<p></p>"), which is truthy but renders
    // blank — judge emptiness by the text that survives strip_tags, not the raw value.
    $lead = trim(strip_tags((string) $description));
    $layout = in_array($layout, ['stack', 'split', 'animation'], true) ? $layout : 'split';

    // Morphing needs something to morph between; with fewer than two words fall back to the
    // static headline so a half-filled setting never renders an empty title.
    $words = collect($words)->map(fn ($word) => trim((string) $word))->filter()->values();
    $morphing = $layout === 'animation' && $words->count() >= 2;

    if ($layout === 'animation' && ! $morphing) {
        $layout = 'stack';
    }
@endphp

<header {{ $attributes->class(['page-head', 'page-head--' . $layout]) }}>
    <div class="page-head__primary">
        @if($kicker)<p class="page-head__kicker">{{ $kicker }}</p>@endif
        @if($morphing)
            <h1 class="page-head__title">
                <span class="morph" data-morph="{{ $words->toJson() }}">
                    <span class="morph__sizer" aria-hidden="true">@foreach($words as $word)<span>{{ $word }}</span>@endforeach</span>
                    <span class="morph__item" aria-hidden="true">{{ $words->first() }}</span>
                    <span class="morph__item" aria-hidden="true"></span>
                    {{-- The animation is decorative; screen readers get the whole list at once. --}}
                    <span class="morph__sr">{{ $words->implode(', ') }}</span>
                </span>
            </h1>
        @elseif($title)
            <h1 class="page-head__title">{!! nl2br(e($title)) !!}</h1>
        @endif
    </div>
    @if($lead !== '')<p class="page-head__lead">{{ $lead }}</p>@endif
</header>

@if($morphing)
@once
@push('scripts')
{{-- Alpha threshold: blurred edges below the cutoff vanish, the rest goes fully opaque, so two
     overlapping blurred words read as one shape mid-morph. --}}
<svg class="morph__filter" aria-hidden="true" focusable="false" width="0" height="0" style="position:absolute">
    <defs>
        <filter id="morph-threshold">
            <feColorMatrix in="SourceGraphic" type="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 255 -140" />
        </filter>
    </defs>
</svg>
<script>
(() => {
    const MORPH_SECONDS = 1.5;   // time spent morphing from one word to the next
    const HOLD_SECONDS = 0.5;    // time a word stays fully readable before the next morph

    document.querySelectorAll('[data-morph]').forEach((root) => {
        let words;
        try { words = JSON.parse(root.dataset.morph); } catch { return; }
        if (!Array.isArray(words) || words.length < 2) return;

        const items = root.querySelectorAll('.morph__item');
        if (items.length !== 2) return;

        // Respect the OS setting: leave the first word on screen and never animate.
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        let index = 0, morph = 0, hold = HOLD_SECONDS, last = 0, raf = null;
        items[0].textContent = words[0];
        items[1].textContent = words[1];

        // Blur falls away as a word arrives; the exponent keeps it legible early.
        const paint = (el, fraction) => {
            if (fraction >= 1) { el.style.filter = ''; el.style.opacity = '1'; return; }
            if (fraction <= 0) { el.style.filter = ''; el.style.opacity = '0'; return; }
            el.style.filter = `blur(${Math.min(8 / fraction - 8, 100)}px)`;
            el.style.opacity = `${Math.pow(fraction, 0.4) * 100}%`;
        };

        const frame = (now) => {
            raf = requestAnimationFrame(frame);
            const delta = last ? Math.min((now - last) / 1000, 0.1) : 0;
            last = now;

            if (hold > 0) {
                hold -= delta;
                paint(items[0], 1);
                paint(items[1], 0);
                return;
            }

            morph += delta;
            if (morph / MORPH_SECONDS >= 1) {
                index += 1;
                items[0].textContent = words[index % words.length];
                items[1].textContent = words[(index + 1) % words.length];
                morph = 0;
                hold = HOLD_SECONDS;
                paint(items[0], 1);
                paint(items[1], 0);
                return;
            }

            paint(items[0], 1 - morph / MORPH_SECONDS);
            paint(items[1], morph / MORPH_SECONDS);
        };

        // Only burn frames while the headline is actually on screen.
        new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && raf === null) {
                    last = 0;
                    raf = requestAnimationFrame(frame);
                } else if (!entry.isIntersecting && raf !== null) {
                    cancelAnimationFrame(raf);
                    raf = null;
                }
            });
        }).observe(root);
    });
})();
</script>
@endpush
@endonce
@endif
