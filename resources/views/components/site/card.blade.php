{{-- 프로젝트 카드 — Figma si7-homepage node 30:80 (Default / Hover).
     호버하면 프로젝트에 설정된 Category·Sector 가 뱃지로 나타난다. --}}
@props([
    'project',
    'title' => null,
    'meta' => null,
    'ratio' => 'wide',
    'eager' => false,
    'sizes' => '(max-width: 767px) 100vw, 50vw',
    'heading' => 'h3',
    'dataCategories' => null,
])

@php
    $cardTitle = $title ?: $project->title;
    // 서브타이틀은 넘겨준 값(보통 client)만 사용 — description 폴백 없음. 없으면 빈 줄.
    $cardMeta = $meta ?? '';
    $categoryIds = $dataCategories ?? implode(',', $project->category_ids ?? []);

    // 뱃지 = 관리자에서 프로젝트에 연결한 Category 다음 Sector 순서.
    // 몇 개가 한 줄에 들어가는지는 렌더된 폭에 달려 있어 서버에서 못 정한다.
    // 전부 내보내고 card-badges 스크립트가 첫 줄에 안 들어가는 것들을 접어 +N 으로 바꾼다.
    $badges = $project->categories->pluck('title')
        ->concat($project->sectors->pluck('title'))
        ->filter()
        ->values();
@endphp

<a {{ $attributes->class('card') }} href="{{ route('projects.show', $project->slug ?: $project->id) }}" data-project-card data-categories="{{ $categoryIds }}">
    <x-site.image :media="$project" role="cover" :ratio="$ratio" :eager="$eager" :sizes="$sizes" :alt="$project->imageAltText('cover') ?: $cardTitle" />

    <span class="card__text">
        <{{ $heading }} class="card__title">{{ $cardTitle }}</{{ $heading }}>
        <span class="card__meta">{!! $cardMeta !== '' ? e($cardMeta) : '&nbsp;' !!}</span>
    </span>

    @if($badges->isNotEmpty())
        {{-- aria-hidden: 링크 이름이 "프로젝트명 + 설명 + 태그 전부"로 길어지는 걸 막는다.
             시각적으로만 보조하는 정보라 스크린리더에는 노출하지 않는다. --}}
        <span class="card__badges" aria-hidden="true" data-card-badges>
            @foreach($badges as $i => $badge)
                <span class="card__badge" style="--i:{{ $i }}">{{ $badge }}</span>
            @endforeach
            <span class="card__badge" data-badge-more hidden></span>
        </span>
    @endif
</a>

@include('site.partials.card-badges')
