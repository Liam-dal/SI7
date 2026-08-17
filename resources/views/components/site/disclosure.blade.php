@props([
    'label',
    'open' => false,
    'name' => null,
])

<details {{ $attributes->class('disclosure') }} @if($name) name="{{ $name }}" @endif @if($open) open @endif>
    <summary class="disclosure__label">
        <span>{{ $label }}</span>
        <span class="disclosure__mark" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 12h-6m0 0H6m6 0V6m0 6v6"/></svg>
        </span>
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
