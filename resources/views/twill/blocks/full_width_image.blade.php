@twillBlockTitle('Full width image')
@twillBlockIcon('image')
@twillBlockGroup('Content')

<x-twill::medias name="image" label="Image" :max="1" />

<x-twill::select
    name="ratio"
    label="Ratio"
    default="default"
    :options="[
        ['value' => 'default', 'label' => 'Original ratio'],
        ['value' => 'square', 'label' => 'Square (1:1)'],
        ['value' => 'wide', 'label' => 'Wide (1.72:1)'],
        ['value' => 'hero', 'label' => 'Hero (1.85:1)'],
    ]"
    note="Crop the image above to the same ratio in its Crop tab. The ratio chosen here is what the site renders."
/>

<x-twill::input name="caption" label="Caption (optional)" :translated="true" />
