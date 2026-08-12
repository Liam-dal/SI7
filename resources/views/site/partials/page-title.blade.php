@php
    $level = $level ?? 1;
    $class = trim('page-title ' . ($class ?? ''));
@endphp
<h{{ $level }} class="{{ $class }}">{{ $title }}</h{{ $level }}>
