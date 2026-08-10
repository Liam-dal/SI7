<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $item->title }}</title>
    @include('site.partials.fonts')
    <style>
        .project-main { max-width: 1280px; margin: 0 auto; padding: 82px var(--page-pad) 0; }
        .project-intro { display: grid; grid-template-columns: minmax(0, 2fr) minmax(220px, 1fr); gap: 48px; margin-bottom: 78px; }
        .project-kicker { margin: 0 0 12px; color: var(--muted); font-size: var(--caption-size); line-height: var(--caption-leading); letter-spacing: var(--caption-tracking); }
        .project-title { margin: 0; font-family: 'SI7', Arial, sans-serif; font-size: clamp(4rem, 10vw, var(--page-title-size)); font-weight: 600; line-height: var(--page-title-leading); letter-spacing: var(--page-title-tracking); }
        .project-summary { margin: 0; align-self: end; font-size: var(--paragraph-size); line-height: var(--paragraph-leading); letter-spacing: var(--paragraph-tracking); }
        .project-cover, .project-gallery img { display: block; width: 100%; height: auto; border-radius: var(--card-radius) !important; }
        .project-meta { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; margin: 32px 0 72px; padding: 12px 0; border-top: 1px solid var(--rule); border-bottom: 1px solid var(--rule); }
        .project-meta dt { color: var(--muted); font-size: var(--body-small-size); line-height: var(--body-small-leading); letter-spacing: var(--body-small-tracking); }.project-meta dd { margin: 6px 0 0; font-size: var(--body-size); line-height: var(--body-leading); letter-spacing: var(--body-tracking); }
        .project-content { max-width: 860px; }.project-gallery { display: grid; gap: 16px; margin-top: 48px; }.related { margin-top: var(--section-space); padding-top: 12px; border-top: 1px solid var(--rule); }.related h2 { margin: 0 0 34px; font-size: 14px; font-weight: 500; }.related-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }.related-grid a { text-decoration: none; }.related-grid img, .related-grid div { display:block; width:100%; aspect-ratio:1; object-fit:cover; border-radius:var(--card-radius) !important; }.related-grid h3 { margin:12px 0 3px; font-size:1.4rem; line-height:1; font-weight:500; letter-spacing:-.01em; }.related-grid p { margin:0; color:var(--muted); font-size:14px; }
        @media(max-width:767px){ .project-main { padding-top: 58px; }.project-intro { grid-template-columns: 1fr; gap: 28px; margin-bottom: 56px; }.project-title { font-size: clamp(4rem, 20vw, 7rem); }.project-meta, .related-grid { grid-template-columns: 1fr; }.project-meta { margin-bottom: 52px; }.related { margin-top: 72px; } }
    </style>
</head>
<body>
    @include('site.partials.chrome')
    <main class="project-main">
        <header class="project-intro">
            <div>
            <p class="project-kicker">
                {{ collect([$item->client, $item->project_completed_at ? \Illuminate\Support\Carbon::parse($item->project_completed_at)->format('Y') : null])->filter()->join(' · ') }}
            </p>
            <h1 class="project-title">
                {{ $item->title }}
            </h1>
            </div>
            @if($item->description)
                <p class="project-summary">
                    {{ $item->description }}
                </p>
            @endif
        </header>

        @if($item->hasImage('cover'))
            <img class="project-cover" src="{{ $item->image('cover') }}" alt="{{ $item->imageAltText('cover') }}" />
        @endif

        @if($item->role || $item->technologies)
            <dl class="project-meta">
                @if($item->role)<div><dt>역할</dt><dd>{{ $item->role }}</dd></div>@endif
                @if($item->technologies)<div><dt>사용 기술</dt><dd>{{ $item->technologies }}</dd></div>@endif
            </dl>
        @endif

        <article class="project-content">
            {!! $item->renderBlocks() !!}
        </article>

        @if(count($item->images('gallery')))
            <section class="project-gallery">
                @foreach($item->images('gallery') as $image)
                    <img src="{{ $image }}" alt="" />
                @endforeach
            </section>
        @endif

        @if(($relatedProjects ?? collect())->isNotEmpty())
            <section class="related">
                <h2>More work</h2>
                <div class="related-grid">
                    @foreach(($relatedProjects ?? collect()) as $relatedProject)
                        <a href="{{ route('projects.show', $relatedProject->slug ?: $relatedProject->id) }}">
                            @if($relatedProject->hasImage('cover'))
                                <img src="{{ $relatedProject->image('cover') }}" alt="{{ $relatedProject->imageAltText('cover') }}" />
                            @else
                                <div style="display: grid; place-items: center; background: #e1e1e1; color: #737373; font-size: 12px;">IMAGE</div>
                            @endif
                            <h3>{{ $relatedProject->title }}</h3>
                            @if($relatedProject->client)<p>{{ $relatedProject->client }}</p>@endif
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </main>
    @include('site.partials.footer')
</body>
</html>
