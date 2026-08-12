@php
    $variant = $variant ?? 'grid';
    $wide = $variant === 'wide';
    $crop = $crop ?? 'wide';
    $year = $project->project_completed_at ? \Illuminate\Support\Carbon::parse($project->project_completed_at)->format('Y') : null;
    $categoryIds = $project->category_ids ?? [];
@endphp
<a class="project-card project-card--{{ $variant }}" href="{{ route('projects.show', $project->slug ?: $project->id) }}" data-project-card data-categories="{{ implode(',', $categoryIds) }}">
    <span class="project-card__media">
        @if($project->hasImage('cover'))
            @include('site.partials.responsive-image', [
                'model' => $project,
                'role' => 'cover',
                'crop' => $crop,
                'class' => 'project-card__image',
                'sizes' => $wide ? 'min(86vw, 980px)' : '(max-width: 767px) 100vw, 33vw',
                'loading' => $loading ?? 'lazy',
            ])
        @else
            <span class="project-card__blank">IMAGE</span>
        @endif
    </span>
    <h{{ $headingLevel ?? 3 }} class="project-card__title">{{ $title ?? $project->title }}</h{{ $headingLevel ?? 3 }}>
    @if($description ?? $project->description ?? $project->client)
        <p class="project-card__description">{{ $description ?? $project->description ?? $project->client }}</p>
    @endif
    @if($showYear ?? false)
        <p class="project-card__year">{{ $year ?: '—' }}</p>
    @endif
</a>
