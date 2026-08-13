@if($block->hasImage('image', 'default'))
    <figure class="block-full-image">
        @include('site.partials.responsive-image', ['model' => $block, 'role' => 'image', 'class' => 'block-full-image__image', 'sizes' => '100vw'])
        @if($blockValue($block, 'caption'))
            <figcaption>{{ $blockValue($block, 'caption') }}</figcaption>
        @endif
    </figure>
@endif
