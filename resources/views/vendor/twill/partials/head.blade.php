<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="robots" content="noindex,nofollow" />

<title>{{ config('app.name') }} {{ config('twill.admin_app_title_suffix') }}</title>

<!-- Fonts -->
@if(app()->isProduction())
    <link href="{{ twillAsset('Inter-Regular.woff2') }}" rel="preload" as="font" type="font/woff2" crossorigin>
    <link href="{{ twillAsset('Inter-Medium.woff2') }}" rel="preload" as="font" type="font/woff2" crossorigin>
@endif

<!-- CSS -->
@if(app()->isProduction())
    <link href="{{ twillAsset('chunk-common.css') }}" rel="preload" as="style" crossorigin/>
    <link href="{{ twillAsset('chunk-vendors.css') }}" rel="preload" as="style" crossorigin/>
@endif

@unless(config('twill.dev_mode', false))
    <link href="{{ twillAsset('chunk-common.css') }}" rel="stylesheet" crossorigin/>
    <link href="{{ twillAsset('chunk-vendors.css' )}}" rel="stylesheet" crossorigin/>
@endunless

<!-- head.js -->
<script>
    !function(e){var i=window.A17||{},n=e.documentElement,l=window;i.browserSpec="html5",i.touch=!!("ontouchstart"in l||l.documentTouch&&e instanceof DocumentTouch),i.objectFit="objectFit"in n.style,window.A17=i,n.className=n.className.replace(/\bno-js\b/," js "+i.browserSpec+(i.touch?" touch":" no-touch")+(i.objectFit?" objectFit":" no-objectFit"))}(document);
</script>

{{-- SI7 관리자 커스텀 CSS --}}
<style>
    /* 블록 선택 버튼을 1칼럼 전체폭으로 (기본은 width:calc(50%-5px) 2칼럼) */
    .editorSidebar__blocks .editorSidebar__button { width: 100% !important; }

    /* 설명(note)을 해당 입력 필드 바로 아래로.
       Twill 기본값은 note 를 라벨 우측(.input__note) 또는 버튼 위(.fileField__note,
       .media__note)에 position:absolute 로 얹어서, 문구가 길면 라벨·버튼과 겹친다. */
    .input:has(> .input__label > .input__note) { display: flex; flex-direction: column; }
    .input:has(> .input__label > .input__note) > .input__label { display: contents; }
    .input:has(> .input__label > .input__note) > :not(.input__label) { margin-top: 10px; }
    .input > .input__label > .input__note {
        position: static !important;
        display: block !important;
        order: 99;
        margin-top: 8px;
        line-height: 1.45;
        white-space: normal;
    }
    .fileField__note, .media__note {
        position: static !important;
        float: none !important;
        display: block !important;
        margin: 8px 0 0 !important;
        line-height: 1.45;
        text-align: left;
    }
</style>

@stack('extra_css')
@stack('extra_js_head')
