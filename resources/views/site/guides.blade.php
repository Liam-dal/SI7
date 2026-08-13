@extends('site.layouts.app')

@php
    $pageTitle = $siteSettings?->guide_page_title ?: 'Guide';
    $pageDescription = $siteSettings?->guide_page_description ?: '스튜디오의 생각과 과정을 담은 글.';
@endphp

@section('title', $pageTitle)

@section('content')
<div class="page page--standard component-guides">
    <x-site.page-head align="stack" :title="$pageTitle" :description="$pageDescription" />

    @if($guides->isEmpty())
        <p class="empty">아직 등록된 글이 없습니다.</p>
    @else
        @php
            $items = $guides->map(fn ($g) => [
                'category' => $g->category,
                'title' => $g->headline,
                'href' => route('guides.show', $g->slug ?: $g->id),
                'cover' => $g->hasImage('cover') ? $g : null,
            ]);
        @endphp
        <x-site.updates-list :items="$items" />
    @endif
</div>
@endsection
