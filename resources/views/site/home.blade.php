@extends('site.layouts.app')

@section('title', $siteSettings?->logo_text ?: 'SI7')

@section('content')
@php
    $heroTitle = $siteSettings?->homepage_title ?: "Work with ideas,\nmade visible.";
    $featureBands = [
        ['features' => $mainFeatures, 'section' => $featureSections->get('main'), 'fallback' => 'Featured work', 'key' => 'main'],
        ['features' => $secondaryFeatures, 'section' => $featureSections->get('secondary'), 'fallback' => 'More featured work', 'key' => 'secondary'],
        ['features' => $additionalFeatures, 'section' => $featureSections->get('additional'), 'fallback' => 'Additional features', 'key' => 'additional'],
    ];
@endphp

<div class="page page--home">
    <x-site.main-hero
        :eyebrow="$siteSettings?->homepage_eyebrow ?: 'Independent creative practice'"
        :title="$heroTitle"
        :description="$siteSettings?->homepage_description"
    />

    @foreach($featureBands as $band)
        <x-site.feature-section
            :features="$band['features']"
            :section="$band['section']"
            :fallback-title="$band['fallback']"
            :carousel-key="$band['key']"
        />
    @endforeach

    <section class="section">
        <x-site.section-head title="All work" action="View all work ↗" :action-href="route('projects')" />
        @if($regularProjects->isEmpty())
            <p class="empty">일반 목록에 표시할 공개 프로젝트가 없습니다.</p>
        @else
            <x-site.media-grid :layout="$siteSettings?->homepage_regular_grid === 'grid_3' ? '3' : 'editorial'">
                @foreach($regularProjects as $project)
                    <x-site.card :project="$project" :meta="$project->description ?: $project->client" />
                @endforeach
            </x-site.media-grid>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-carousel]').forEach((button) => {
    button.addEventListener('click', () => {
        const track = document.querySelector(`[data-carousel-track="${button.dataset.carousel}"]`);
        if (track) track.scrollBy({ left: track.clientWidth * .92 * (button.dataset.direction === 'next' ? 1 : -1), behavior: 'smooth' });
    });
});
</script>
@endpush
