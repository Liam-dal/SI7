@props([
    'title',
    'description' => null,
    'action' => null,
    'actionHref' => null,
    'heading' => 'h2',
    'titleCase' => 'normal',
])

<div {{ $attributes->class('section-top') }}>
    <div>
        <{{ $heading }} @class(['label', 'label--normal' => $titleCase === 'normal'])>{{ $title }}</{{ $heading }}>
        @if($description)<p class="section-description">{{ $description }}</p>@endif
    </div>
    @if($action && $actionHref)
        <a class="label" href="{{ $actionHref }}">{{ $action }}</a>
    @elseif(isset($slot) && trim($slot))
        <div class="section-top__actions">{{ $slot }}</div>
    @endif
</div>
