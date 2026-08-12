@props(['project', 'title' => null, 'meta' => null, 'ratio' => 'wide', 'eager' => false, 'sizes' => '(max-width: 767px) 100vw, 50vw', 'heading' => 'h3', 'dataCategories' => null])

@php
    $cardTitle = $title ?: $project->title;
    $cardMeta = $meta ?? ($project->description ?: $project->client);
    $categoryIds = $dataCategories ?? implode(',', $project->category_ids ?? []);
@endphp

<a {{ $attributes->class('card') }} href="{{ route('projects.show', $project->slug ?: $project->id) }}" data-project-card data-categories="{{ $categoryIds }}">
    <x-site.image :media="$project" role="cover" :ratio="$ratio" :eager="$eager" :sizes="$sizes" :alt="$project->imageAltText('cover') ?: $cardTitle" />
    <{{ $heading }} class="card__title">{{ $cardTitle }}</{{ $heading }}>
    @if($cardMeta)<p class="card__meta">{{ $cardMeta }}</p>@endif
</a>
