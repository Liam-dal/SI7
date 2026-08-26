@extends('site.layouts.app')

@php
    $pageTitle = $siteSettings?->projects_page_title;
    $pageDescription = $siteSettings?->projects_page_description;
@endphp

@section('title', $pageTitle ?: 'Work')

@section('content')
<div class="page page--standard page--projects">
    <x-site.page-head :title="$pageTitle" :description="$pageDescription" layout="split" />
    @if($categories->isNotEmpty())
        <x-site.filters :items="$categories" :selected="$selectedCategoryId" class="work-filters" />
    @endif
    @if($projects->isEmpty())
        <p class="empty">공개된 프로젝트가 아직 없습니다.</p>
    @else
        <x-site.media-grid layout="3" data-project-grid>
            @foreach($projects as $project)
                <x-site.card :project="$project" :meta="$project->subtitle" :eager="$loop->index < 2" heading="h2" :data-categories="implode(',', $project->category_ids ?? [])" />
            @endforeach
        </x-site.media-grid>
        <p class="empty filter-empty" hidden>이 카테고리에 공개된 프로젝트가 아직 없습니다.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
(() => {
    const cards = [...document.querySelectorAll('[data-project-card]')];
    const links = [...document.querySelectorAll('[data-category-filter]')];
    const empty = document.querySelector('.filter-empty');
    if (!cards.length || !links.length) return;
    const applyFilter = (categoryId) => {
        let shown = 0;
        cards.forEach((card) => { const matches = !categoryId || card.dataset.categories.split(',').includes(String(categoryId)); card.hidden = !matches; if (matches) shown++; });
        links.forEach((link) => link.classList.toggle('is-active', String(link.dataset.categoryId) === String(categoryId || '')));
        if (empty) empty.hidden = shown > 0;
    };
    links.forEach((link) => link.addEventListener('click', (event) => { event.preventDefault(); const categoryId = link.dataset.categoryId; history.pushState({}, '', link.href); applyFilter(categoryId); }));
    window.addEventListener('popstate', () => applyFilter(new URLSearchParams(location.search).get('category')));
    applyFilter(new URLSearchParams(location.search).get('category'));
})();
</script>
@endpush
