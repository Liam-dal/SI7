@if($block->hasImage('image', 'default'))
    <figure style="margin:2rem 0;">
        <img src="{{ $block->image('image', 'default') }}" alt="{{ $block->imageAltText('image') }}" style="display:block;width:100%;height:auto;" />
        @if($block->input('caption'))
            <figcaption style="margin-top:.5rem;">{{ $block->input('caption') }}</figcaption>
        @endif
    </figure>
@endif
