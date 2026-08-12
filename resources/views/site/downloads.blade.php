@extends('site.layouts.app')

@php
    $pageTitle = $siteSettings?->downloads_page_title ?: 'Downloads';
    $pageDescription = $siteSettings?->downloads_page_description ?: '회사 및 프로젝트 관련 문서를 다운로드할 수 있습니다.';
@endphp

@section('title', $pageTitle)

@section('content')
<div class="page page--standard component-downloads">
    <x-site.page-head :title="$pageTitle" :description="$pageDescription" align="stack" />
    <div class="download-layout">
        <div aria-hidden="true"></div>
        <div>
        @if($downloads->isEmpty())
            <p class="empty">공개된 다운로드 파일이 아직 없습니다.</p>
        @else
            <section class="download-list">
            @foreach($downloads as $download)
                @php
                    $file = $download->fileObject('document');
                    $extension = strtoupper(pathinfo($file?->filename ?? '', PATHINFO_EXTENSION));
                    $bytes = is_numeric($file?->size) ? (int) $file->size : null;
                    $size = $bytes
                        ? ($bytes >= 1048576
                            ? round($bytes / 1048576, 1) . ' MB'
                            : max(1, round($bytes / 1024)) . ' KB')
                        : ($file?->size ?: null);
                @endphp

                @if($file)
                    <x-site.disclosure :label="$download->title" name="downloads">
                        @if($download->description)
                            <p class="download-disclosure__description">{{ $download->description }}</p>
                        @endif

                        @if($download->tag || $extension || $size)
                            <p class="download-disclosure__meta">
                                @if($download->tag)<span>{{ $download->tag }}</span>@endif
                                @if($extension || $size)<span>{{ collect([$extension, $size])->filter()->implode(' · ') }}</span>@endif
                            </p>
                        @endif

                        <x-slot:actions>
                            <x-site.button variant="outline" :href="$download->file('document')" download>Download ↓</x-site.button>
                        </x-slot:actions>
                    </x-site.disclosure>
                @endif
            @endforeach
            </section>
        @endif
        </div>
    </div>
</div>
@endsection
