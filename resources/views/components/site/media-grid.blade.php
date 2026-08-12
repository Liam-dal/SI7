@props(['layout' => 'editorial'])

<div {{ $attributes->class(['cards', 'cards--' . $layout]) }}>
    {{ $slot }}
</div>
