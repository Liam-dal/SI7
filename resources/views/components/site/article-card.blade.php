@props([
    'href' => '#',
    'media' => null,
    'role' => 'cover',
    'ratio' => 'wide',
    'category' => null,
    'title' => null,
    'sizes' => '(max-width: 767px) 100vw, 33vw',
])

<a {{ $attributes->class('article-card') }} href="{{ $href }}">
    @if($media && $media->hasImage($role))
        <x-site.image :media="$media" :role="$role" :ratio="$ratio" :sizes="$sizes" :alt="$title" />
    @endif

    @if($category)
        <p class="article-card__category">{{ $category }}</p>
    @endif

    @if($title)
        <h3 class="article-card__title">{{ $title }}</h3>
    @endif
</a>
