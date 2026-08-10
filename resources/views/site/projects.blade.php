<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projects</title>
    @include('site.partials.fonts')
    <style>
        main { padding: 78px var(--page-pad) 0; }
        h1 { margin: 0 0 var(--section-space); font-family: 'SI7', Arial, sans-serif; font-size: clamp(5rem, 16vw, var(--page-title-size)); font-weight: 600; line-height: var(--page-title-leading); letter-spacing: var(--page-title-tracking); }
        .browse { display: grid; grid-template-columns: minmax(160px, 24%) 1fr; gap: 24px; margin-bottom: 78px; padding-top: 12px; border-top: 1px solid var(--rule); }.browse h2 { margin: 0; font-size: var(--caption-size); line-height: var(--caption-leading); letter-spacing: var(--caption-tracking); font-weight: 500; }.category-links { display: flex; flex-wrap: wrap; gap: 8px 22px; }.category-links a { font-size: var(--body-size); line-height: var(--body-leading); letter-spacing: var(--body-tracking); text-underline-offset: 3px; }.category-links a.active { font-weight: 700; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 52px 16px; }.project { text-decoration: none; }.project:nth-child(5n + 1) { grid-column: 1 / -1; }.project img, .blank { display:block; width:100%; aspect-ratio:1; object-fit:cover; border-radius:var(--card-radius); background:#dedede; }.project:nth-child(5n + 1) img, .project:nth-child(5n + 1) .blank { aspect-ratio: 1.72; }.blank { display:grid; place-items:center; color:var(--muted); font-size:var(--caption-size); }.project h2 { margin:12px 0 3px; font-size:var(--body-size); line-height:var(--body-leading); font-weight:500; letter-spacing:var(--body-tracking); }.project p { margin:0; color:var(--muted); font-size:var(--body-small-size); line-height:var(--body-small-leading); letter-spacing:var(--body-small-tracking); }.empty { color:var(--muted); font-size:var(--body-size); }
        @media (max-width:767px) { main { padding-top: 58px; } h1 { margin-bottom: 72px; font-size: clamp(5rem, 24vw, 8rem); }.browse { grid-template-columns: 1fr; gap: 18px; margin-bottom: 52px; }.grid { grid-template-columns: 1fr; gap: 40px; }.project:nth-child(5n + 1) { grid-column: auto; }.project:nth-child(5n + 1) img, .project:nth-child(5n + 1) .blank { aspect-ratio: 1; } }
    </style>
</head>
<body>
    @include('site.partials.chrome')
    <main>
        <h1>Work</h1>
        @if($categories->isNotEmpty())
            <section class="browse">
                <h2>Browse categories</h2>
                <nav class="category-links" aria-label="프로젝트 카테고리">
                    <a href="{{ route('projects') }}" @class(['active' => !$selectedCategoryId])>All projects</a>
                    @foreach($categories as $category)
                        <a href="{{ route('projects', ['category' => $category->id]) }}" @class(['active' => $selectedCategoryId === $category->id])>{{ $category->title }}</a>
                    @endforeach
                </nav>
            </section>
        @endif
        @if($projects->isEmpty())
            <p class="empty">이 카테고리에 공개된 프로젝트가 아직 없습니다.</p>
        @else
            <section class="grid">
                @foreach($projects as $project)
                    <a class="project" href="{{ route('projects.show', $project->slug ?: $project->id) }}">
                        @if($project->hasImage('cover'))
                            <img src="{{ $project->image('cover') }}" alt="{{ $project->imageAltText('cover') }}" />
                        @else
                            <span class="blank">IMAGE</span>
                        @endif
                        <h2>{{ $project->title }}</h2>
                        @if($project->client)<p>{{ $project->client }}</p>@endif
                    </a>
                @endforeach
            </section>
        @endif
    </main>
    @include('site.partials.footer')
</body>
</html>
