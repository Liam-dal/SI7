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
    $featureMeta = fn ($feature) => $feature->description ?: $feature->project->description ?: $feature->project->client;
@endphp

@if($features->isNotEmpty())
<section @class(['section', 'feature-band', 'feature-band--dark' => $isDark])>
    <div class="feature-band__inner">
        <x-site.section-head :title="$sectionTitle" :description="$section?->description">
            @if($isCarousel)
                <button class="btn-icon" type="button" data-carousel="{{ $carouselKey }}" data-direction="previous" aria-label="이전">←</button>
                <button class="btn-icon" type="button" data-carousel="{{ $carouselKey }}" data-direction="next" aria-label="다음">→</button>
            @endif
        </x-site.section-head>

        @if($isCarousel)
            <div class="feature-carousel" data-carousel-track="{{ $carouselKey }}">
                @foreach($features as $feature)
                    <x-site.card
                        :project="$feature->project"
                        :title="$featureTitle($feature)"
                        :meta="$featureMeta($feature)"
                        ratio="wide"
                        :eager="$loop->first"
                        sizes="(max-width: 767px) 86vw, min(86vw, 980px)"
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
                        :sizes="$gridLayout === 'editorial' ? '(max-width: 767px) 100vw, 50vw' : '(max-width: 767px) 100vw, 33vw'"
                    />
                @endforeach
            </x-site.media-grid>
        @endif
    </div>
</section>
@endif
