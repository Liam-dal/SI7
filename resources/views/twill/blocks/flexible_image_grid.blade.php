@twillBlockTitle('Flexible image grid')
@twillBlockIcon('image')
@twillBlockGroup('Content')

<x-twill::select
    name="columns"
    label="Columns"
    default="auto"
    :options="[
        ['value' => 'auto', 'label' => 'Auto (flows to fit the width)'],
        ['value' => '2', 'label' => '2 columns'],
        ['value' => '3', 'label' => '3 columns'],
    ]"
    note="Auto arranges images flexibly according to their size."
/>

<x-twill::select
    name="ratio"
    label="Ratio"
    default="default"
    :options="[
        ['value' => 'default', 'label' => 'Original ratio (flexible)'],
        ['value' => 'square', 'label' => 'Square (1:1)'],
        ['value' => 'landscape', 'label' => 'Landscape (3:2)'],
        ['value' => 'portrait', 'label' => 'Portrait (3:4)'],
    ]"
    note="Original ratio (flexible) keeps each image at its own proportions. If you pick a specific ratio, crop the images to match in their Crop tab."
/>

<x-twill::select
    name="fit_mode"
    label="Image fitting"
    default="crop"
    :options="[
        ['value' => 'crop', 'label' => 'Crop (fill the box)'],
        ['value' => 'fit', 'label' => 'Fit (scale down so the whole image shows)'],
    ]"
    note="Fit shows tall images in full without cropping and fills the leftover space with the background colour below. Only has an effect when a ratio is selected."
/>

<x-twill::input
    name="bg_color"
    label="Background colour (letterboxing for Fit)"
    placeholder="#F2F0EB"
    note="Enter a hex code (e.g. #FFFFFF, #000000). Leave empty for a transparent background."
/>

<x-twill::medias
    name="images"
    label="Images"
    :max="20"
    note="Arranges images flexibly, keeping their original proportions."
/>
