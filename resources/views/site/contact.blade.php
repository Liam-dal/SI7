<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $contact?->title ?: 'Contact' }}</title>
    @include('site.partials.fonts')
    <style>
        :root { --black:#000; --secondary:#757575; --tertiary:#949494; --button:#F2F2F2; --gutter:16px; }
        * { box-sizing:border-box; }
        body { margin:0; background:var(--page-bg); color:var(--text); font-family:'SI7', Arial, sans-serif; font-size:var(--body-size); line-height:var(--body-leading); letter-spacing:var(--body-tracking); font-weight:500; }
        a { color:inherit; }
        .header { height:70px; display:flex; align-items:center; justify-content:space-between; padding:0 var(--gutter); font-size:var(--menu-size); line-height:var(--menu-leading); letter-spacing:var(--menu-tracking); }
        .header a:first-child { font-weight:600; text-decoration:none; }
        .container { padding:0 var(--gutter); }
        .heading { width:83.333%; margin:0; font-family:'SI7',Arial,sans-serif; font-size:clamp(3.5rem,8vw,var(--hero-size)); font-weight:600; line-height:var(--hero-leading); letter-spacing:var(--hero-tracking); text-wrap:balance; }
        .heading--muted { color:var(--tertiary); margin-top:112px; }
        .heading + .heading { margin-top:0; }
        .contact-button { display:inline-flex; align-items:center; height:54px; margin-top:48px; padding:16px 24px; background:var(--button); border:0; border-radius:4px; color:var(--black); font:500 18px/1 'SI7',Arial,sans-serif; text-decoration:none; }
        .cards { display:flex; gap:var(--gutter); margin:80px 0 0; padding:0; list-style:none; }
        .card { flex:1 1 0; min-width:0; }
        .media { position:relative; aspect-ratio:1; overflow:hidden; border-radius:var(--card-radius); background:#e1e1e1; }
        .media img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0; animation:swap 12s infinite; }
        .media img:nth-child(1) { opacity:1; animation-delay:0s; }
        .media img:nth-child(2) { animation-delay:4s; }
        .media img:nth-child(3) { animation-delay:8s; }
        .media:empty::after { content:'IMAGE'; position:absolute; inset:0; display:grid; place-items:center; color:#757575; font-size:14px; }
        .overlay { position:absolute; inset:0; display:grid; place-items:center; padding:16px; background:rgb(0 0 0 / .2); color:#fff; text-align:center; font-size:5.3125rem; font-weight:450; line-height:88%; letter-spacing:-.012em; }
        .card h3 { margin:24px 0 0; font-size:var(--body-size); line-height:var(--body-leading); letter-spacing:var(--body-tracking); font-weight:500; }
        .card p, .card address { margin:0; color:var(--secondary); font-size:var(--body-size); line-height:var(--body-leading); letter-spacing:var(--body-tracking); font-style:normal; }
        .card .phone { display:inline-block; margin-top:24px; font-size:var(--body-size); line-height:var(--body-leading); letter-spacing:var(--body-tracking); }
        .card address { margin-top:24px; color:var(--black); }
        .join { width:83.333%; margin:224px 0 96px; font-size:clamp(3.5rem,8vw,var(--hero-size)); font-weight:450; line-height:var(--hero-leading); letter-spacing:var(--hero-tracking); }
        .links { display:flex; gap:16px 32px; flex-wrap:wrap; margin:0 0 48px; font-size:var(--body-size); line-height:var(--body-leading); letter-spacing:var(--body-tracking); }
        @keyframes swap { 0%, 30% { opacity:1 } 33.333%, 100% { opacity:0 } }
        @media (max-width:767px) { .header { height:56px; padding:0 12px; } .container { padding:0 12px; } .heading, .join { width:100%; font-size:3.5rem; } .heading--muted { margin-top:72px; } .cards { flex-direction:column; gap:56px; margin-top:64px; } .contact-button { margin-top:32px; } .overlay { font-size:3.5rem; } .join { margin:128px 0 56px; } }
    </style>
</head>
<body>
    <header class="header">
        <a href="/">@if($siteSettings?->hasImage('logo'))<img src="{{ $siteSettings->image('logo') }}" alt="{{ $siteSettings->logo_text ?: '홈' }}" style="display:block; max-width:160px; height:24px;">@else{{ $siteSettings?->logo_text ?: 'PORTFOLIO' }}@endif</a>
        <nav style="display:flex; gap:20px" aria-label="주요 메뉴">
            <a href="{{ route('projects') }}">Projects</a>
            <a href="{{ route('downloads') }}">Download</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>
    <main class="container" id="contact">
        <h1 class="heading heading--muted">{{ $contact?->title ?: 'Contact' }}</h1>
        <h2 class="heading">{{ $contact?->description ?: 'Let’s chat about how we can support you on your journey.' }}</h2>
        @if($contact?->email)
            <a class="contact-button" href="mailto:{{ $contact->email }}">Get in touch</a>
        @else
            <span class="contact-button">Get in touch</span>
        @endif

        <ul class="cards">
            <li class="card">
                <div class="media">
                    @foreach($contact?->images('contact_primary') ?? [] as $image)<img src="{{ $image }}" alt="" />@endforeach
                    <div class="overlay">{{ $contact?->location ?: 'Studio' }}</div>
                </div>
                <h3>{{ $contact?->location ?: 'Studio' }}</h3>
                @if($contact?->availability)<p>{{ $contact->availability }}</p>@endif
                @if($contact?->phone)<a class="phone" href="tel:{{ preg_replace('/[^0-9+]/', '', $contact->phone) }}">{{ $contact->phone }}</a>@endif
            </li>
            <li class="card">
                <div class="media">
                    @foreach($contact?->images('contact_secondary') ?? [] as $image)<img src="{{ $image }}" alt="" />@endforeach
                    <div class="overlay">Get in touch</div>
                </div>
                <h3>Contact</h3>
                @if($contact?->email)<a class="phone" href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>@endif
                @if($contact?->meeting_url)<p style="margin-top:24px"><a href="{{ $contact->meeting_url }}" target="_blank" rel="noreferrer">미팅 예약 ↗</a></p>@endif
            </li>
        </ul>

        <h2 class="join">Join our team</h2>
        <div class="links">
            @if($contact?->instagram_url)<a href="{{ $contact->instagram_url }}" target="_blank" rel="noreferrer">Instagram ↗</a>@endif
            @if($contact?->linkedin_url)<a href="{{ $contact->linkedin_url }}" target="_blank" rel="noreferrer">LinkedIn ↗</a>@endif
            @if($contact?->behance_url)<a href="{{ $contact->behance_url }}" target="_blank" rel="noreferrer">Behance ↗</a>@endif
        </div>
    </main>
    @include('site.partials.footer')
</body>
</html>
