@twillBlockTitle('Featured section')
@twillBlockIcon('text')
@twillBlockGroup('Content')

<x-twill::input
    name="title"
    label="Section title"
    :maxlength="120"
    note="Falls back to 'Featured work' when left empty."
/>

<x-twill::input
    name="description"
    label="Section description (optional)"
    type="textarea"
    :rows="3"
    :maxlength="500"
/>

<x-twill::select
    name="layout_style"
    label="Layout style"
    :options="[
        ['value' => 'carousel', 'label' => 'Carousel (light) — horizontal slides'],
        ['value' => 'carousel_dark', 'label' => 'Carousel (dark) — black background, white text'],
        ['value' => 'grid_3', 'label' => '3-column grid — even three columns'],
        ['value' => 'grid_editorial', 'label' => 'Editorial grid — first card larger'],
    ]"
    default="carousel"
/>

<x-twill::select
    name="cards_per_view"
    label="Cards per view (carousel)"
    default="4"
    :options="[
        ['value' => '2', 'label' => '2 cards'],
        ['value' => '3', 'label' => '3 cards'],
        ['value' => '4', 'label' => '4 cards'],
        ['value' => 'slide', 'label' => 'Slide (1 card + peek of the next)'],
    ]"
/>

<x-twill::select
    name="card_ratio"
    label="Card image ratio"
    default="wide"
    :options="[
        ['value' => 'wide', 'label' => 'Wide (1.65:1)'],
        ['value' => 'square', 'label' => 'Square (1:1)'],
        ['value' => 'tall', 'label' => 'Portrait (4:5)'],
    ]"
/>

<x-twill::input
    name="bg_color"
    label="Background colour (dark style, optional)"
    placeholder="#000000"
    note="Hex colour used instead of black in the dark carousel. Leave empty for black. A Neat config below takes priority."
/>

<x-twill::input
    name="neat_config"
    label="Neat gradient config (JSON, optional)"
    type="textarea"
    :rows="6"
    note="Paste the config object { ... } from neat.firecms.co to put an animated gradient behind the dark carousel."
/>

<x-twill::browser
    name="projects"
    module-name="projects"
    label="Projects"
    :max="24"
    note="Pick the projects shown in this section and drag to reorder."
/>
