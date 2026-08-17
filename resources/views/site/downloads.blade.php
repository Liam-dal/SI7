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
        @if(session('download_error'))
            <p class="download-error">{{ session('download_error') }}</p>
        @endif

        @if($downloads->isEmpty())
            <p class="empty">공개된 다운로드 파일이 아직 없습니다.</p>
        @else
            <section class="download-list">
            @foreach($downloads as $download)
                @php
                    // 파일은 로케일별로 저장되나(업로드 시 로케일) 다운로드는 언어 무관이어야 하므로,
                    // 현재 로케일에 없으면 역할이 맞는 아무 파일이나 사용.
                    $file = $download->fileObject('document') ?: $download->files->firstWhere('pivot.role', 'document');
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
                            @if($download->require_password && filled($download->download_password))
                                <form method="POST" action="{{ route('download.file', $download) }}" class="download-lock">
                                    @csrf
                                    <input type="password" name="password" class="download-lock__input" placeholder="비밀번호" autocomplete="off" required>
                                    <button type="submit" class="download-lock__btn">🔒 Download ↓</button>
                                </form>
                            @else
                                <x-site.button variant="outline" :href="$download->file('document')" download>Download ↓</x-site.button>
                            @endif
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
