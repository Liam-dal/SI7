@extends('site.layouts.app')

@section('title', $item->title)

@section('content')
@php
    $office = $item->officeLocation?->title ?: $item->office;
@endphp
<div class="page page--standard component-person">
    {{-- 상단: 2단 (좌 이름/오피스/바이오, 우 프로필 사진) --}}
    <div class="person-top">
        <div class="person-top__main">
            <h1 class="person-name">{{ $item->title }}</h1>
            @if($office)
                <p class="person-office">{{ $office }}</p>
            @endif
            @if($item->biography)
                <div class="person-bio prose">{!! $item->biography !!}</div>
            @endif
        </div>

        <div class="person-top__media">
            @if($item->hasImage('main'))
                <x-site.image
                    :media="$item"
                    role="main"
                    ratio="square"
                    :eager="true"
                    sizes="(max-width: 767px) 100vw, 50vw"
                    :alt="$item->title"
                />
            @endif
        </div>
    </div>

    {{-- 하단: 2단 (좌 Role/Office/Start year) --}}
    <div class="person-info">
        <dl class="person-facts">
            @if($item->teamRole)
                <div class="person-facts__row"><dt>Role</dt><dd>{{ $item->teamRole->title }}</dd></div>
            @endif
            @if($office)
                <div class="person-facts__row"><dt>Office</dt><dd>{{ $office }}</dd></div>
            @endif
            @if($item->start_year)
                <div class="person-facts__row"><dt>Start year</dt><dd>{{ $item->start_year }}</dd></div>
            @endif
        </dl>
    </div>

    {{-- 다음 줄: Related content --}}
    @if(($relatedProjects ?? collect())->isNotEmpty())
        <section class="section">
            <x-site.section-head title="Related content" />
            <x-site.media-grid layout="3">
                @foreach($relatedProjects as $project)
                    <x-site.card
                        :project="$project"
                        :meta="$project->subtitle"
                        sizes="(max-width: 767px) 100vw, 33vw"
                    />
                @endforeach
            </x-site.media-grid>
        </section>
    @endif
</div>
@endsection
