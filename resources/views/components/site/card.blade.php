@props(['project', 'title' => null, 'meta' => null, 'ratio' => 'wide', 'eager' => false, 'sizes' => '(max-width: 767px) 100vw, 50vw', 'heading' => 'h3', 'dataCategories' => null])

@php
    $cardTitle = $title ?: $project->title;
    // 서브타이틀은 넘겨준 값(보통 client)만 사용 — description 폴백 없음. 없으면 빈 줄.
    $cardMeta = $meta ?? '';
    $categoryIds = $dataCategories ?? implode(',', $project->category_ids ?? []);
@endphp

<a {{ $attributes->class('card') }} href="{{ route('projects.show', $project->slug ?: $project->id) }}" data-project-card data-categories="{{ $categoryIds }}">
    <x-site.image :media="$project" role="cover" :ratio="$ratio" :eager="$eager" :sizes="$sizes" :alt="$project->imageAltText('cover') ?: $cardTitle" />
    <{{ $heading }} class="card__title">{{ $cardTitle }}</{{ $heading }}>
    <p class="card__meta">{!! $cardMeta !== '' ? e($cardMeta) : '&nbsp;' !!}</p>
</a>
