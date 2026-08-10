<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Downloads</title>
    @include('site.partials.fonts')
    <style>
        * { box-sizing:border-box; } body { margin:0; background:var(--page-bg); color:var(--text); font-family:'SI7',Arial,sans-serif; font-size:var(--body-size); line-height:var(--body-leading); letter-spacing:var(--body-tracking); } a { color:inherit; }
        .header { height:70px; display:flex; align-items:center; justify-content:space-between; padding:0 16px; font-size:var(--menu-size); line-height:var(--menu-leading); letter-spacing:var(--menu-tracking); }.header>a{font-weight:600;text-decoration:none}.header nav{display:flex;gap:20px}
        main { max-width:1100px; padding:112px 16px 96px; } h1 { margin:0 0 24px; font-family:'SI7',Arial,sans-serif; font-size:clamp(3.5rem,10vw,var(--page-title-size)); font-weight:600; line-height:var(--page-title-leading); letter-spacing:var(--page-title-tracking); }.lead{max-width:440px;margin:0 0 80px;font-size:var(--paragraph-size);line-height:var(--paragraph-leading);letter-spacing:var(--paragraph-tracking)}.list{border-top:1px solid #000}.item{display:grid;grid-template-columns:1fr auto;gap:20px;align-items:center;padding:20px 0;border-bottom:1px solid #000;text-decoration:none}.item:hover{background:#f2f2f2}.title{margin:0;font-size:var(--body-size);line-height:var(--body-leading);letter-spacing:var(--body-tracking)}.description{margin:8px 0 0;color:var(--muted);font-size:var(--body-small-size);line-height:var(--body-small-leading);letter-spacing:var(--body-small-tracking)}.action{font-size:var(--body-small-size);line-height:var(--body-small-leading);letter-spacing:var(--body-small-tracking);white-space:nowrap;text-decoration:underline;text-underline-offset:3px}.empty{color:var(--muted);font-size:var(--body-size)}
        @media(max-width:767px){.header{height:56px;padding:0 12px}main{padding:72px 12px}h1{font-size:3.5rem}.lead{margin-bottom:56px}.item{padding:16px 0}.title{font-size:20px}}
    </style>
</head>
<body>
    <header class="header"><a href="/">@if($siteSettings?->hasImage('logo'))<img src="{{ $siteSettings->image('logo') }}" alt="{{ $siteSettings->logo_text ?: '홈' }}" style="display:block; max-width:160px; height:24px;">@else{{ $siteSettings?->logo_text ?: 'PORTFOLIO' }}@endif</a><nav aria-label="주요 메뉴"><a href="{{ route('projects') }}">Projects</a><a href="{{ route('downloads') }}">Download</a><a href="{{ route('contact') }}">Contact</a></nav></header>
    <main>
        <h1>Downloads</h1><p class="lead">회사 및 프로젝트 관련 문서를 다운로드할 수 있습니다.</p>
        @if($downloads->isEmpty()) <p class="empty">공개된 다운로드 파일이 아직 없습니다.</p>
        @else <section class="list">@foreach($downloads as $download) @if($file = $download->fileObject('document'))
            <a class="item" href="{{ $download->file('document') }}" download><div><h2 class="title">{{ $download->title }}</h2>@if($download->description)<p class="description">{{ $download->description }}</p>@endif</div><span class="action">Download ↓</span></a>
        @endif @endforeach</section>@endif
    </main>
    @include('site.partials.footer')
</body>
</html>
