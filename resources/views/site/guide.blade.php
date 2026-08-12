@extends('site.layouts.app')

@section('title', $item->title)
@section('description', $item->description)

@section('content')
<article class="page page--standard component-guide guide-article">
    <header class="guide-article__header">
        @if($item->category)
            <p class="guide-article__eyebrow">{{ $item->category }}</p>
        @endif

        <h1 class="guide-article__title">{{ $item->title }}</h1>

        @if($item->publication_date)
            <p class="guide-article__meta">
                <time datetime="{{ $item->publication_date->toDateString() }}">{{ $item->publication_date->format('Y.m.d') }}</time>
            </p>
        @endif

        @if($item->description)
            <p class="guide-article__lead">{{ $item->description }}</p>
        @endif
    </header>

    @if($item->hasImage('cover'))
        <figure class="guide-article__hero">
            <x-site.image
                :media="$item"
                role="cover"
                ratio="wide"
                :eager="true"
                sizes="100vw"
                :alt="$item->title"
            />
        </figure>
    @endif

    <div class="guide-article__body prose">{!! $item->renderBlocks() !!}</div>

    @if(($relatedGuides ?? collect())->isNotEmpty())
        <section class="guide-article__related">
            <x-site.section-head title="Up next" action="View all ↗" :action-href="route('guides')" />
            <x-site.media-grid layout="3">
                @foreach($relatedGuides as $guide)
                    <x-site.article-card
                        :href="route('guides.show', $guide->slug ?: $guide->id)"
                        :media="$guide"
                        :category="$guide->category"
                        :title="$guide->title"
                    />
                @endforeach
            </x-site.media-grid>
        </section>
    @endif
</article>
@endsection
