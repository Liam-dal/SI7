@props([
    'features',
    'section' => null,
    'fallbackTitle' => 'Featured work',
    'carouselKey' => 'main',
])

@php
    $style = $section?->layout_style ?: 'carousel';
    $isDark = $style === 'carousel_dark';
    $isCarousel = in_array($style, ['carousel', 'carousel_dark'], true);
    $gridLayout = $style === 'grid_editorial' ? 'editorial' : '3';
    $sectionTitle = $section?->title ?: $fallbackTitle;

    $featureTitle = fn ($feature) => $feature->title ?: $feature->project->title;
    $featureMeta = fn ($feature) => $feature->description ?: $feature->project->subtitle;

    // 카드 비율(와이드/정사각/세로), 배경(다크일 때만): Neat > 배경색 > 검정
    $cardRatio = in_array($section?->card_ratio, ['wide', 'square', 'tall'], true) ? $section->card_ratio : 'wide';
    $perView = in_array($section?->cards_per_view, ['2', '3', '4', 'slide'], true) ? $section->cards_per_view : '4';
    $neatConfig = $isDark ? trim((string) ($section?->neat_config ?? '')) : '';
    $bgColor = $isDark ? ($section?->bg_color ?: null) : null;
    $hasNeat = $neatConfig !== '';
    $neatId = 'feat-neat-' . $carouselKey;
@endphp

@if($features->isNotEmpty())
<section @class(['section', 'feature-band', 'feature-band--dark' => $isDark])@if($bgColor && ! $hasNeat) style="background: {{ $bgColor }}"@endif>
    @if($hasNeat)
        <canvas class="feature-band__neat" id="{{ $neatId }}" aria-hidden="true"></canvas>
    @endif
    <div class="feature-band__inner">
        <x-site.section-head :title="$sectionTitle" :description="$section?->description">
            @if($isCarousel)
                <x-site.carousel-button direction="previous" :carousel="$carouselKey" />
                <x-site.carousel-button direction="next" :carousel="$carouselKey" />
            @endif
        </x-site.section-head>

        @if($isCarousel)
            <div class="feature-carousel feature-carousel--{{ $perView }}" data-carousel-track="{{ $carouselKey }}">
                @foreach($features as $feature)
                    <x-site.card
                        :project="$feature->project"
                        :title="$featureTitle($feature)"
                        :meta="$featureMeta($feature)"
                        :ratio="$cardRatio"
                        :eager="$loop->first"
                        sizes="(max-width: 767px) 60vw, 380px"
                    />
                @endforeach
            </div>
        @else
            <x-site.media-grid :layout="$gridLayout">
                @foreach($features as $feature)
                    <x-site.card
                        :project="$feature->project"
                        :title="$featureTitle($feature)"
                        :meta="$featureMeta($feature)"
                        :ratio="$cardRatio"
                        :sizes="$gridLayout === 'editorial' ? '(max-width: 767px) 100vw, 50vw' : '(max-width: 767px) 100vw, 33vw'"
                    />
                @endforeach
            </x-site.media-grid>
        @endif
    </div>
</section>

@if($hasNeat)
@push('scripts')
<script type="module">
    import { NeatGradient } from "https://esm.sh/@firecms/neat";
    (() => {
        const el = document.getElementById(@json($neatId));
        if (!el) return;
        try {
            const config = {!! $neatConfig !!};
            new NeatGradient(Object.assign({}, config, { ref: el }));
        } catch (e) { console.warn('Neat feature bg failed:', e); el.remove(); }
    })();
</script>
@endpush
@endif
@endif
