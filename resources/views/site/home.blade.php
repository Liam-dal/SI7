@extends('site.layouts.app')

@section('content')
@php
    $heroTitle = $siteSettings?->homepage_title ?: "Work with ideas,\nmade visible.";
@endphp

<div class="page page--home">
    @if($heroBuilder ?? null)
        <x-site.design-hero :data="$heroBuilder" />
    @else
        <x-site.main-hero
            :eyebrow="$siteSettings?->homepage_eyebrow ?: 'Independent creative practice'"
            :title="$heroTitle"
            :description="$siteSettings?->homepage_description"
        />
    @endif

    @foreach($featureBands as $band)
        <x-site.feature-section
            :features="$band['features']"
            :section="$band['section']"
            :carousel-key="$band['key']"
        />
    @endforeach
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
