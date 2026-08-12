@extends('site.layouts.app')

@section('title', $item->title)
@section('description', $item->description)

@section('content')
<div class="page page--standard component-project" data-project-about>
    <x-site.page-head
        align="split"
        :title="$item->title"
    />

    <button class="project-about__toggle" type="button" data-project-about-btn aria-expanded="false" aria-controls="project-about-panel">
        <span>About the project</span>
        <span class="project-about__icon" aria-hidden="true"></span>
    </button>

    <div class="project-about__row">
        <div class="project-about__main">
            @if($item->video_url)
                <x-site.video :url="$item->video_url" :autoplay="(bool) $item->video_autoplay" :loop="(bool) $item->video_autoloop" :title="$item->title" />
            @elseif($item->hasImage('cover'))
                @include('site.partials.responsive-image', ['model' => $item, 'role' => 'cover', 'crop' => 'hero', 'class' => 'project-cover', 'sizes' => '100vw', 'loading' => 'eager'])
            @endif

            <article class="project-content prose">{!! $item->renderBlocks() !!}</article>

            @if(count($item->images('gallery')))
                <section class="project-gallery">
                    @foreach($item->images('gallery') as $image)<img src="{{ $image }}" alt="" loading="lazy" decoding="async">@endforeach
                </section>
            @endif
        </div>

        <aside class="project-about__panel" id="project-about-panel" aria-label="About the project">
            <div class="project-about__inner">
                @if($item->case_study_text)
                    <div class="project-about__text prose">{!! $item->case_study_text !!}</div>
                @elseif($item->description)
                    <p class="project-about__text">{{ $item->description }}</p>
                @endif

                <div class="project-about__credits">
                    <dl class="project-about__col">
                        @if($item->client)<div class="project-about__credit"><dt>Client</dt><dd>{{ $item->client }}</dd></div>@endif
                        @if($item->sectors->isNotEmpty())<div class="project-about__credit"><dt>Sector</dt><dd>{{ $item->sectors->pluck('title')->join(', ') }}</dd></div>@endif
                        @if($item->categories->isNotEmpty())<div class="project-about__credit"><dt>Discipline</dt><dd>{!! $item->categories->pluck('title')->map(fn ($t) => e($t))->join('<br>') !!}</dd></div>@endif
                    </dl>
                    <dl class="project-about__col">
                        @if($item->offices->isNotEmpty())<div class="project-about__credit"><dt>Office</dt><dd>{{ $item->offices->pluck('title')->join(', ') }}</dd></div>@endif
                        @if($item->people->isNotEmpty())<div class="project-about__credit"><dt>Team</dt><dd>{!! $item->people->pluck('title')->map(fn ($t) => e($t))->join('<br>') !!}</dd></div>@endif
                        @if($item->project_completed_at)<div class="project-about__credit"><dt>Year</dt><dd>{{ \Illuminate\Support\Carbon::parse($item->project_completed_at)->format('Y') }}</dd></div>@endif
                        @if($item->external_url)<div class="project-about__credit"><dt>Link</dt><dd><a href="{{ $item->external_url }}" target="_blank" rel="noopener noreferrer">{{ $item->external_link_label ?: 'Visit' }} ↗</a></dd></div>@endif
                    </dl>
                </div>
            </div>
        </aside>
    </div>

    @if(($relatedProjects ?? collect())->isNotEmpty())
        <section class="section">
            <x-site.section-head title="Up next" title-case="normal" action="View all work ↗" :action-href="route('projects')" />
            <x-site.media-grid layout="3">
                @foreach($relatedProjects as $relatedProject)
                    <x-site.card :project="$relatedProject" :meta="$relatedProject->client" sizes="(max-width: 767px) 100vw, 33vw" />
                @endforeach
            </x-site.media-grid>
        </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-project-about]').forEach((wrap) => {
    const btn = wrap.querySelector('[data-project-about-btn]');
    if (!btn) return;
    btn.addEventListener('click', () => {
        const open = wrap.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', String(open));
    });
});
</script>
@endpush
