@extends('site.layouts.app')

@section('content')
@php
    $heroEyebrow = $siteSettings?->homepage_eyebrow;
    $heroTitle = $siteSettings?->homepage_title;
    $heroDescription = $siteSettings?->homepage_description;
    // Comma- or newline-separated in Settings. Two or more words switch the headline to the
    // morphing variant (Figma "Main Head" Layout=animation); otherwise the static title runs.
    $heroWords = collect(preg_split('/[,\n]/', (string) $siteSettings?->homepage_headline_words))
        ->map(fn ($word) => trim($word))
        ->filter()
        ->values()
        ->all();
    $heroLayout = count($heroWords) >= 2 ? 'animation' : 'stack';
    // A cleared Wysiwyg still stores markup, so measure the text, not the raw field.
    $heroHasText = filled($heroEyebrow) || filled($heroTitle) || count($heroWords) >= 2
        || filled(trim(strip_tags((string) $heroDescription)));
@endphp

<div class="page page--home">
    @if($heroBuilder ?? null)
        <x-site.design-hero :data="$heroBuilder" />
    @elseif($heroHasText)
        <x-site.page-head :layout="$heroLayout" :kicker="$heroEyebrow" :title="$heroTitle" :description="$heroDescription" :words="$heroWords" />
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
