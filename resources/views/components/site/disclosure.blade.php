@props([
    'label',
    'open' => false,
    'name' => null,
])

<details {{ $attributes->class('disclosure') }} @if($name) name="{{ $name }}" @endif @if($open) open @endif>
    <summary class="disclosure__label">
        <span>{{ $label }}</span>
        <span class="disclosure__mark" aria-hidden="true"><i>+</i></span>
    </summary>

    <div class="disclosure__panel">
        <div class="disclosure__body">
            {{ $slot }}

            @isset($actions)
                <div class="disclosure__actions">{{ $actions }}</div>
            @endisset
        </div>
    </div>
</details>
