@extends('site.layouts.app')

@php
    $pageTitle = $siteSettings?->contact_page_title ?: $contact?->title;
    $pageDescription = $siteSettings?->contact_page_description ?: $contact?->description;
@endphp

@section('title', $pageTitle ?: 'Contact')

@section('content')
<div class="page page--standard component-contact" id="contact">
    <x-site.page-head align="stack" :title="$pageTitle" :description="$pageDescription" />

    @if($offices->isNotEmpty())
        <ul class="offices">
            @foreach($offices as $office)
                <li><x-site.office :office="$office" /></li>
            @endforeach
        </ul>
    @endif

    <nav class="contact-links" aria-label="소셜 링크">
        @if($contact?->instagram_url)<a href="{{ $contact->instagram_url }}" target="_blank" rel="noreferrer">Instagram ↗</a>@endif
        @if($contact?->linkedin_url)<a href="{{ $contact->linkedin_url }}" target="_blank" rel="noreferrer">LinkedIn ↗</a>@endif
        @if($contact?->behance_url)<a href="{{ $contact->behance_url }}" target="_blank" rel="noreferrer">Behance ↗</a>@endif
    </nav>
</div>
@endsection

@push('scripts')
<script>
(() => {
    const nodes = document.querySelectorAll('[data-office-time]');
    if (!nodes.length) return;

    const tick = () => nodes.forEach((element) => {
        try {
            element.textContent = new Intl.DateTimeFormat('en-US', {
                hour: 'numeric', minute: '2-digit', hour12: true, timeZone: element.dataset.tz,
            }).format(new Date()).toLowerCase();
        } catch (error) {
            element.textContent = '';
        }
    });

    tick();
    window.setInterval(tick, 15000);
})();
</script>
@endpush
