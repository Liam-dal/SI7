<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteSettings?->logo_text ?: 'Portfolio' }}</title>
    @include('site.partials.fonts')
    <style>
        main { padding: 92px var(--page-pad) 0; }
        .eyebrow { margin: 0 0 18px; font-size: var(--caption-size); line-height: var(--caption-leading); letter-spacing: var(--caption-tracking); }
        .intro { max-width: 1120px; margin: 0 0 var(--section-space); font-family: 'SI7', Arial, sans-serif; font-size: clamp(4rem, 10.5vw, var(--hero-size)); font-weight: 600; line-height: var(--hero-leading); letter-spacing: var(--hero-tracking); }
        .section { margin-top: var(--section-space); }
        .section-top { display: flex; justify-content: space-between; gap: 24px; align-items: baseline; margin-bottom: 14px; padding-top: 12px; border-top: 1px solid var(--rule); }
        .section-top h2, .section-top a { margin: 0; font-size: var(--caption-size); line-height: var(--caption-leading); letter-spacing: var(--caption-tracking); font-weight: 500; }
        .section-description { margin: 6px 0 0; color: var(--muted); font-size: var(--body-small-size); line-height: var(--body-small-leading); letter-spacing: var(--body-small-tracking); }
        .carousel-head { display:flex; justify-content:space-between; align-items:baseline; gap:24px; }
        .carousel-controls { display:flex; gap:6px; }
        .carousel-controls button { width:32px; height:28px; padding:0; border:1px solid var(--rule); border-radius:0; background:transparent; color:inherit; cursor:pointer; font:inherit; }
        .feature-carousel { display: grid; grid-auto-columns: minmax(min(86vw, 980px), 1fr); grid-auto-flow: column; gap: 16px; overflow-x: auto; padding-bottom: 10px; scroll-snap-type: x mandatory; scrollbar-width: none; }
        .feature-carousel::-webkit-scrollbar { display:none; }
        .feature-carousel .work-card { scroll-snap-align: start; }
        .feature-carousel img, .feature-carousel .blank { display: block; width: 100%; aspect-ratio: 1.65; object-fit: cover; border-radius: var(--card-radius); background: #dedede; }
        .feature-grid, .work-grid { display: grid; gap: 52px 16px; }
        .feature-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .work-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .work-card { text-decoration: none; }
        .feature-grid img, .feature-grid .blank, .work-grid img, .work-grid .blank { display: block; width: 100%; aspect-ratio: 1; object-fit: cover; border-radius: var(--card-radius); background: #dedede; }
        .work-grid--editorial .work-card:first-child { grid-column: 1 / -1; }
        .work-grid--editorial .work-card:first-child img, .work-grid--editorial .work-card:first-child .blank { aspect-ratio: 1.65; }
        .work-grid--grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .blank { display: grid; place-items: center; color: var(--muted); font-size: 13px; }
        .work-card h3 { margin: 12px 0 3px; font-size: var(--body-size); font-weight: 500; line-height: var(--body-leading); letter-spacing: var(--body-tracking); }
        .work-card p { margin: 0; color: var(--muted); font-size: var(--body-small-size); line-height: var(--body-small-leading); letter-spacing: var(--body-small-tracking); }
        .empty { color: var(--muted); font-size: 18px; }
        @media(max-width:767px){ main { padding-top: 64px; } .intro { margin-bottom: 72px; font-size: clamp(3.8rem, 18vw, 6rem); } .feature-grid, .work-grid, .work-grid--grid-3 { grid-template-columns: 1fr; gap: 40px; } .work-grid--editorial .work-card:first-child { grid-column: auto; } .work-grid--editorial .work-card:first-child img, .work-grid--editorial .work-card:first-child .blank { aspect-ratio: 1; } }
    </style>
</head>
<body>
    @include('site.partials.chrome')
    <main>
        <p class="eyebrow">Independent creative practice</p>
        <h1 class="intro">Work with ideas,<br>made visible.</h1>
        @php($card = fn ($feature) => ['project' => $feature->project, 'title' => $feature->title ?: $feature->project->title, 'description' => $feature->description ?: $feature->project->description ?: $feature->project->client])
        @php($mainSection = $featureSections->get('main'))
        @php($secondarySection = $featureSections->get('secondary'))
        @php($additionalSection = $featureSections->get('additional'))

        @if($mainFeatures->isNotEmpty())
            <section class="section">
                <div class="section-top carousel-head"><div><h2>{{ $mainSection?->title ?: 'Featured work' }}</h2>@if($mainSection?->description)<p class="section-description">{{ $mainSection->description }}</p>@endif</div><div class="carousel-controls" aria-label="피처 프로젝트 넘기기"><button type="button" data-carousel="main" data-direction="previous" aria-label="이전">←</button><button type="button" data-carousel="main" data-direction="next" aria-label="다음">→</button></div></div>
                <div class="feature-carousel" data-carousel-track="main">@foreach($mainFeatures as $feature) @php($copy = $card($feature)) @php($project = $copy['project'])
                    <a class="work-card" href="{{ route('projects.show', $project->slug ?: $project->id) }}">
                        @if($project->hasImage('cover'))<img src="{{ $project->image('cover') }}" alt="{{ $project->imageAltText('cover') }}">@else<span class="blank">IMAGE</span>@endif
                        <h3>{{ $copy['title'] }}</h3>@if($copy['description'])<p>{{ $copy['description'] }}</p>@endif
                    </a>
                @endforeach</div>
            </section>
        @endif

        @if($secondaryFeatures->isNotEmpty())
            <section class="section">
                <div class="section-top"><div><h2>{{ $secondarySection?->title ?: 'More featured work' }}</h2>@if($secondarySection?->description)<p class="section-description">{{ $secondarySection->description }}</p>@endif</div></div>
                <div class="feature-grid">@foreach($secondaryFeatures as $feature) @php($copy = $card($feature)) @php($project = $copy['project'])
                    <a class="work-card" href="{{ route('projects.show', $project->slug ?: $project->id) }}">
                        @if($project->hasImage('cover'))<img src="{{ $project->image('cover') }}" alt="{{ $project->imageAltText('cover') }}">@else<span class="blank">IMAGE</span>@endif
                        <h3>{{ $copy['title'] }}</h3>@if($copy['description'])<p>{{ $copy['description'] }}</p>@endif
                    </a>
                @endforeach</div>
            </section>
        @endif

        @if($additionalFeatures->isNotEmpty())
            <section class="section">
                <div class="section-top"><div><h2>{{ $additionalSection?->title ?: 'Additional features' }}</h2>@if($additionalSection?->description)<p class="section-description">{{ $additionalSection->description }}</p>@endif</div></div>
                <div class="feature-grid">@foreach($additionalFeatures as $feature) @php($copy = $card($feature)) @php($project = $copy['project'])
                    <a class="work-card" href="{{ route('projects.show', $project->slug ?: $project->id) }}">
                        @if($project->hasImage('cover'))<img src="{{ $project->image('cover') }}" alt="{{ $project->imageAltText('cover') }}">@else<span class="blank">IMAGE</span>@endif
                        <h3>{{ $copy['title'] }}</h3>@if($copy['description'])<p>{{ $copy['description'] }}</p>@endif
                    </a>
                @endforeach</div>
            </section>
        @endif

        <section class="section">
            <div class="section-top"><h2>All work</h2><a href="{{ route('projects') }}">View all work ↗</a></div>
            @if($regularProjects->isEmpty())<p class="empty">일반 목록에 표시할 공개 프로젝트가 없습니다.</p>
            @else <div class="work-grid work-grid--{{ $siteSettings?->homepage_regular_grid === 'grid_3' ? 'grid-3' : 'editorial' }}">@foreach($regularProjects as $project) @php($copy = ['title' => $project->title, 'description' => $project->description ?: $project->client])
                <a class="work-card" href="{{ route('projects.show', $project->slug ?: $project->id) }}">
                    @if($project->hasImage('cover'))<img src="{{ $project->image('cover') }}" alt="{{ $project->imageAltText('cover') }}">@else<span class="blank">IMAGE</span>@endif
                    <h3>{{ $copy['title'] }}</h3>@if($copy['description'])<p>{{ $copy['description'] }}</p>@endif
                </a>
            @endforeach</div>@endif
        </section>
    </main>
    @include('site.partials.footer')
    <script>
        document.querySelectorAll('[data-carousel]').forEach((button) => {
            button.addEventListener('click', () => {
                const track = document.querySelector(`[data-carousel-track="${button.dataset.carousel}"]`);
                if (!track) return;
                const distance = track.clientWidth * 0.92 * (button.dataset.direction === 'next' ? 1 : -1);
                track.scrollBy({ left: distance, behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>
