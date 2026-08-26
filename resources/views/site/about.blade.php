@extends('site.layouts.app')

@section('title', $siteSettings?->about_page_title ?: 'About')

@section('content')
<div class="page page--standard">
    <x-site.page-head
        layout="split"
        :title="$siteSettings?->about_page_title"
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
