@props(['person', 'sizes' => '(max-width: 767px) 100vw, 33vw', 'eager' => false, 'heading' => 'h3'])

@php
    $name = trim(implode(' ', array_filter([$person->first_name, $person->last_name]))) ?: $person->title;
@endphp

<a {{ $attributes->class('card') }} href="{{ route('people.show', $person->slug ?: $person->id) }}" data-person-card>
    <x-site.image :media="$person" role="main" ratio="square" :eager="$eager" :sizes="$sizes" :alt="$name" placeholder="PROFILE" />
    <{{ $heading }} class="card__title">{{ $name }}</{{ $heading }}>
    @if($person->teamRole)<p class="card__meta">{{ $person->teamRole->title }}</p>@endif
</a>
