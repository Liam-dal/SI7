@php
    // 홈 라우트가 만드는 밴드 구조를 그대로 재현한다.
    // (블록 에디터 프리뷰는 이 뷰를 렌더링하고, 실제 홈은 routes/web.php 에서 같은 값을 조립한다)
    $features = $block->getRelated('projects')
        ->filter(fn ($project) => $project->published)
        ->map(fn ($project) => (object) ['project' => $project, 'title' => null, 'description' => null])
        ->values();

    $section = (object) [
        'title' => $block->input('title'),
        'description' => $block->input('description'),
        'layout_style' => $block->input('layout_style') ?: 'carousel',
        'card_ratio' => $block->input('card_ratio') ?: 'wide',
        'cards_per_view' => $block->input('cards_per_view') ?: '4',
        'bg_color' => $block->input('bg_color'),
        'neat_config' => trim((string) $block->input('neat_config')),
    ];
@endphp

@if($features->isNotEmpty())
    <x-site.feature-section :features="$features" :section="$section" :carousel-key="'sec-'.$block->id" />
@else
    <p style="padding:24px;color:var(--muted,#6E6E6E);font-size:14px">
        아직 선택된 프로젝트가 없습니다. 이 블록의 <strong>Projects</strong> 필드에서 프로젝트를 추가하면 미리보기가 표시됩니다.
    </p>
@endif
