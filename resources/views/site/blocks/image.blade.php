@if($block->hasImage('image', 'default'))
    <figure style="display: grid; gap: 1rem; margin: 2rem 0;">
        @foreach($block->images('image', 'default') as $image)
            <img
                src="{{ $image }}"
                alt="{{ $block->imageAltText('image') }}"
                style="display: block; width: 100%; height: auto; border-radius: .5rem;"
            />
        @endforeach
        @if($block->input('caption'))
            <figcaption style="margin-top: .5rem; color: #6b7280; font-size: .9rem;">
                {{ $block->input('caption') }}
            </figcaption>
        @endif
    </figure>
@endif
