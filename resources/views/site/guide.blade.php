@extends('site.layouts.app')

@section('title', $item->headline)
@section('description', $item->description)

@section('content')
<article class="page page--standard component-guide guide-article">
    <header class="guide-article__header">
        @if($item->guideCategory)
            <p class="guide-article__eyebrow">{{ $item->guideCategory->title }}</p>
        @endif

        <h1 class="guide-article__title">{{ $item->headline }}</h1>

        @if($item->publication_date)
            <p class="guide-article__meta">
                <time datetime="{{ $item->publication_date->toDateString() }}">{{ $item->publication_date->format('Y.m.d') }}</time>
            </p>
        @endif

        @if($item->description)
            <p class="guide-article__lead">{{ $item->description }}</p>
        @endif
    </header>

    @php
        // 커버 영상이 붙어 있으면 커버 이미지 자리에서 대신 재생한다(상세 페이지 한정).
        // 이미지는 포스터 프레임 겸 폴백으로 계속 쓰인다.
        $coverVideo = $item->cover_video_url;
        $coverPoster = $item->hasImage('cover') ? $item->image('cover', 'default') : null;
    @endphp

    @if($coverVideo)
        <figure class="guide-article__hero">
            <x-site.video
                class="guide-article__hero-video"
                :file="$coverVideo"
                :poster="$coverPoster"
                :autoplay="true"
                :loop="true"
                :controls="false"
                :title="$item->headline"
            />
        </figure>

        @include('site.partials.video-viewport')
    @elseif($item->hasImage('cover'))
        <figure class="guide-article__hero">
            <x-site.image
                :media="$item"
                role="cover"
                ratio="wide"
                :eager="true"
                sizes="100vw"
                :alt="$item->headline"
            />
        </figure>
    @endif

    <div class="guide-article__body prose">{!! $item->renderBlocks() !!}</div>

    @include('site.partials.guide-toc')

    @if(($relatedGuides ?? collect())->isNotEmpty())
        <section class="guide-article__related">
            <x-site.section-head title="Up next" action="View all ↗" :action-href="route('guides')" />
            <x-site.media-grid layout="3">
                @foreach($relatedGuides as $guide)
                    <x-site.article-card
                        :href="route('guides.show', $guide->public_slug)"
                        :media="$guide"
                        :category="$guide->guideCategory?->title"
                        :title="$guide->headline"
                    />
                @endforeach
            </x-site.media-grid>
        </section>
    @endif
</article>
@endsection
