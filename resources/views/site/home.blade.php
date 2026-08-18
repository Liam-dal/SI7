@extends('site.layouts.app')

@section('content')
@php
    $heroEyebrow = $siteSettings?->homepage_eyebrow;
    $heroTitle = $siteSettings?->homepage_title;
    $heroDescription = $siteSettings?->homepage_description;
@endphp

<div class="page page--home">
    @if($heroBuilder ?? null)
        <x-site.design-hero :data="$heroBuilder" />
    @elseif(filled($heroEyebrow) || filled($heroTitle) || filled($heroDescription))
        <x-site.main-hero :eyebrow="$heroEyebrow" :title="$heroTitle" :description="$heroDescription" />
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
