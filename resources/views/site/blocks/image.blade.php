@if($block->hasImage('image', 'default'))
    <figure class="block-gallery">
        @foreach($block->images('image', 'default') as $image)
            <img
                src="{{ $image }}"
                alt="{{ $block->imageAltText('image') }}"
                loading="lazy"
            />
        @endforeach
        @if($block->input('caption'))
            <figcaption>
                {{ $block->input('caption') }}
            </figcaption>
        @endif
    </figure>
@endif
