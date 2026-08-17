<!doctype html>
<html lang="{{ config('app.locale', 'ko') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- 블록 편집기 프리뷰가 실제 사이트와 같은 스타일로 보이도록 tokens + site.css 로드 --}}
    @include('site.partials.tokens')
    <link rel="stylesheet" href="{{ route('site.css') }}?v={{ filemtime(resource_path('css/site.css')) }}">

    <style>
        body { margin: 0; background: var(--page-bg, #fff); color: var(--text, #111); }
        /* 프로젝트 본문과 비슷한 폭/여백으로 감싸 실제 배치를 재현 */
        .block-preview__wrap { max-width: var(--measure, 1100px); margin: 0 auto; padding: 32px var(--page-pad, 20px); }
        /* 프리뷰 iframe이 좁아 모바일 미디어쿼리(≤767px)가 걸려도, 설정한 칼럼 수를 유지 */
        .block-gallery--2 { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
        .block-gallery--3 { grid-template-columns: repeat(3, minmax(0, 1fr)) !important; }
        .block-flex-gallery--cols-2 { display: grid !important; grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
        .block-flex-gallery--cols-3 { display: grid !important; grid-template-columns: repeat(3, minmax(0, 1fr)) !important; }
    </style>
</head>
<body>
    <div class="component-project">
        <div class="project-content block-preview__wrap">
            @yield('content')
        </div>
    </div>
</body>
</html>
