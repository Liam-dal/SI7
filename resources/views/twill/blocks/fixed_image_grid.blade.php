@twillBlockTitle('Fixed image grid')
@twillBlockIcon('image')
@twillBlockGroup('Content')

<x-twill::select
    name="columns"
    label="Grid columns"
    :options="[
        ['value' => '2', 'label' => '2 columns'],
        ['value' => '3', 'label' => '3 columns'],
    ]"
    default="3"
/>

<x-twill::select
    name="ratio"
    label="Ratio"
    default="square"
    :options="[
        ['value' => 'default', 'label' => 'Original ratio'],
        ['value' => 'square', 'label' => 'Square (1:1)'],
        ['value' => 'landscape', 'label' => 'Landscape (3:2)'],
        ['value' => 'portrait', 'label' => 'Portrait (3:4)'],
    ]"
    note="Crop the images below to the same ratio in their Crop tab. The grid is unified to the ratio chosen here."
/>

<x-twill::select
    name="fit_mode"
    label="Image fitting"
    default="crop"
    :options="[
        ['value' => 'crop', 'label' => 'Crop (fill the box)'],
        ['value' => 'fit', 'label' => 'Fit (scale down so the whole image shows)'],
    ]"
    note="Fit shows tall images in full without cropping and fills the leftover space with the background colour below."
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
    note="Displays several images arranged in a grid."
/>
