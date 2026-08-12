@props([
    'office' => null,
    'headingLevel' => 'h2',
])

@php
    $tag = $headingLevel;
    $name = $office?->title ?: 'Office';
    $timezone = $office?->timezone ?: 'Asia/Seoul';
    $cityLine = trim(implode(' ', array_filter([$office?->city, $office?->zipcode])));
    $addressLines = collect([$office?->street, $cityLine, $office?->country])->filter()->values();
    $uid = 'office-' . ($office?->id ?? uniqid());
@endphp

<article {{ $attributes->class('office') }}>
    <x-site.image class="office__media" :media="$office" role="office" ratio="wide" placeholder="OFFICE" sizes="(max-width: 1023px) 100vw, 50vw" />

    <{{ $tag }} class="office__name">{{ $name }}</{{ $tag }}>
    <p class="office__time" data-office-time data-tz="{{ $timezone }}" id="{{ $uid }}-time">&nbsp;</p>

    <div class="office__body">
        <div class="office__contact">
            @if($office?->email)
                <a class="office__link" href="mailto:{{ $office->email }}">{{ $office->email }}</a>
            @endif
            @if($office?->phone)
                <a class="office__tel" href="tel:{{ preg_replace('/[^0-9+]/', '', $office->phone) }}">{{ $office->phone }}</a>
            @endif
            @if($addressLines->isNotEmpty())
                <address class="office__address">
                    @foreach($addressLines as $line)
                        {{ $line }}@if(! $loop->last)<br>@endif
                    @endforeach
                </address>
            @endif
            @if($office?->directions_url)
                <a class="office__link office__directions" href="{{ $office->directions_url }}" target="_blank" rel="noreferrer">Get directions ↗</a>
            @endif
        </div>

        @if($office?->short_description)
            <p class="office__note">{{ $office->short_description }}</p>
        @endif
    </div>
</article>
