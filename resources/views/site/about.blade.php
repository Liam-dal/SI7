@extends('site.layouts.app')

@section('title', $siteSettings?->about_page_title ?: 'About')

@php
    $neatOn = $about && $about->use_neat && trim((string) $about->neat_config) !== '';
@endphp

@section('content')
<div class="page page--standard">
    @if($neatOn)
        <div class="about-hero">
            <canvas class="about-hero__canvas" data-neat></canvas>
        </div>
    @endif

    <x-site.page-head
        align="stack"
        :title="$siteSettings?->about_page_title ?: 'About'"
        :description="$siteSettings?->about_page_description"
    />

    @if($about && method_exists($about, 'renderBlocks') && $about->blocks->isNotEmpty())
        <div class="about-blocks">{!! $about->renderBlocks() !!}</div>
    @endif

    <section class="section">
        @if($people->isEmpty())
            <p class="empty">표시할 공개 프로필이 없습니다.</p>
        @else
            <x-site.media-grid layout="3">
                @foreach($people as $person)
                    <x-site.person-card :person="$person" sizes="(max-width: 767px) 100vw, 33vw" />
                @endforeach
            </x-site.media-grid>
        @endif
    </section>
</div>
@endsection

@if($neatOn)
@push('scripts')
<script type="module">
    import { NeatGradient } from "https://esm.sh/@firecms/neat";
    const el = document.querySelector('[data-neat]');
    if (el) {
        try {
            const config = {!! $about->neat_config !!};
            new NeatGradient(Object.assign({}, config, { ref: el }));
        } catch (e) {
            console.warn('Neat gradient init failed:', e);
            el.closest('.about-hero')?.remove();
        }
    }
</script>
@endpush
@endif
