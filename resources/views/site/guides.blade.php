@extends('site.layouts.app')

@php
    $pageTitle = $siteSettings?->guide_page_title;
    $pageDescription = $siteSettings?->guide_page_description;
@endphp

@section('title', $pageTitle ?: 'Guide')

@section('content')
<div class="page page--standard component-guides">
    <x-site.page-head layout="split" :title="$pageTitle" :description="$pageDescription" />

    @if($guides->isEmpty())
        <p class="empty">아직 등록된 글이 없습니다.</p>
    @else
        @php
            $items = $guides->map(fn ($g) => [
                'category' => $g->guideCategory?->title,
                'title' => $g->headline,
                'href' => route('guides.show', $g->public_slug),
                'cover' => $g->hasImage('cover') ? $g : null,
            ]);
        @endphp
        <x-site.updates-list :items="$items" />
    @endif
</div>
@endsection
