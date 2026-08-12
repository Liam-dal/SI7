@if($block->hasImage('images', 'default'))
    <div class="block-flex-gallery">
        @foreach($block->images('images', 'default') as $image)
            <img src="{{ $image }}" alt="{{ $block->imageAltText('images') }}" loading="lazy">
        @endforeach
    </div>
@endif
